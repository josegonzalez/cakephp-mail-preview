<?php
namespace Josegonzalez\MailPreview\Controller;

use Cake\Controller\Exception\MissingActionException;
use Cake\Core\Configure;
use Cake\Event\Event;
use Exception;
use Josegonzalez\MailPreview\Controller\AppController;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class MailPreviewController extends AppController
{
    public function beforeRender(Event $event)
    {
        if ($this->request->action === 'index') {
            return;
        }

        if (!isset($this->viewVars['email'])) {
            throw new Exception('No email was set for the view');
        } else {
            $this->viewBuilder()->layout(false);
            $this->viewBuilder()->template('email');
        }

        $part = $this->request->query('part');
        if (!empty($part) && $part === 'message') {
            $this->response->body($this->viewVars['email']['message']);

            return $this->response->send();
        }
    }

    public function index()
    {
        $this->viewBuilder()->layout(false);
        $this->set('mailPreviews', $this->getMailPreviews());
    }

    public function email()
    {
        $name = implode('::', $this->request->params['pass']);
        list($mailPreview, $email) = $this->findPreview($this->request->params['pass']);
        $partType = $this->request->query('part', null);

        $this->set('title', sprintf('Mailer Preview for %s', $name));

        $email = $mailPreview->$email();
        $this->viewBuilder()->layout = false;
        $this->set('email', $email);

        if ($partType) {
            if ($part = $this->findPart($email, $partType)) {
                $this->response->type($partType);
                $this->response->body($part);

                return $this->response->send();
            } else {
                throw new MissingActionException("Email part '#{partType}' not found in #{@preview.name}##{email}");
            }
        } else {
            $this->set('part', $this->findPreferredPart($email, $this->request->query('part')));
            $this->viewBuilder()->layout = false;
        }
    }

    protected function getMailPreviews()
    {
        // todo: automatically retrieve these
        $previewClass = Configure::read('MailPreview.previewClass');
        if (!empty($previewClass)) {
            return $previewClass;
        }

        $mailPreviews = [];
        foreach ($this->getMailPreviewsFromNamespace() as $mailPreview) {
            $mailPreviews[] = new $mailPreview;
        }

        return $mailPreviews;
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

        throw new MissingActionException("Mailer preview ${name} not found");
    }

    protected function findPreferredPart($email, $format)
    {
        if (empty($format)) {
            foreach ($email['parts'] as $part => $content) {
                return $part;
            }
        }

        return $part;
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

    protected function getMailPreviewsFromNamespace()
    {
        $path = APP . 'Mailer' . DS . 'View' . DS;
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
}
