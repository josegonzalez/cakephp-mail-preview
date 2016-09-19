<?php
namespace Josegonzalez\MailPreview\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class MailPreviewController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->layout(false);
        $this->set('mailPreviews', $this->getMailPreviews());
    }

    public function email()
    {
        $name = implode('::', $this->request->params['pass']);
        list($mailPreview, $emailName) = $this->findPreview($this->request->params['pass']);
        $partType = $this->request->query('part', null);

        $email = $mailPreview->$emailName();
        $this->viewBuilder()->layout(false);

        if ($partType) {
            if ($part = $this->findPart($email, $partType)) {
                $this->response->type($partType);
                $this->response->body($part);

                return $this->response->send();
            }

            throw new Exception(sprintf(
                "Email part '%s' not found in %s::%s",
                $partType,
                $mailPreview->previewName(),
                $emailName
            ));
        }

        $this->set('title', sprintf('Mailer Preview for %s', $name));
        $this->set('email', $email);
        $this->set('part', $this->findPreferredPart($email, $this->request->query('part')));
    }

    protected function getMailPreviews()
    {
        $classNames = Configure::read('MailPreview.Previews.classNames');
        if (empty($classNames)) {
            $path = APP . 'Mailer' . DS . 'Preview' . DS;
            $classNames = $this->getMailPreviewsFromPath($path);
        }

        $mailPreviews = [];
        foreach ($classNames as $className) {
            $mailPreviews[] = new $className;
        }

        return $mailPreviews;
    }

    protected function getMailPreviewsFromPath($path)
    {
        $fqcns = [];

        $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $phpFiles = new RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2; // Skip namespace keyword and whitespace
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0]) {
                    $index += 2; // Skip class keyword and whitespace
                    $fqcns[] = $namespace . '\\' . $tokens[$index][1];
                }
            }
        }

        return $fqcns;
    }

    protected function findPart($email, $partType)
    {
        foreach ($email['parts'] as $part => $content) {
            if ($part === $partType) {
                return $content;
            }
        }

        return null;
    }

    protected function findPreferredPart($email, $format)
    {
        if (empty($format)) {
            foreach ($email['parts'] as $part => $content) {
                return $part;
            }
        }

        return null;
    }

    protected function findPreview($path)
    {
        list($previewName, $emailName) = $path;
        foreach ($this->getMailPreviews() as $mailPreview) {
            if ($mailPreview->previewName() !== $previewName) {
                continue;
            }

            $email = $mailPreview->find($emailName);
            if (!$email) {
                continue;
            }

            return [$mailPreview, $email];
        }

        throw new Exception("Mailer preview ${name} not found");
    }
}
