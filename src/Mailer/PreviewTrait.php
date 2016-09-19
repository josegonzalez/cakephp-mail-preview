<?php
namespace Josegonzalez\MailPreview\Mailer;

use Cake\Mailer\Exception\MissingActionException;
use Cake\Mailer\Transport\DebugTransport;
use ReflectionClass;

trait PreviewTrait
{

    /**
     * Previews email using the debug transport.
     *
     * @param string $action The name of the mailer action to trigger.
     * @param array $args Arguments to pass to the triggered mailer action.
     * @param array $headers Headers to set.
     * @return array
     * @throws \Cake\Mailer\Exception\MissingActionException
     * @throws \BadMethodCallException
     */
    public function preview($action, $args = [], $headers = [])
    {
        if (!method_exists($this, $action)) {
            throw new MissingActionException([
                'mailer' => $this->getName() . 'Mailer',
                'action' => $action,
            ]);
        }

        $this->_email->setHeaders($headers);
        if (!$this->_email->viewBuilder()->template()) {
            $this->_email->viewBuilder()->template($action);
        }

        call_user_func_array([$this, $action], $args);

        // HACK: We don't want to send the email anywhere accidentally
        $transport = new DebugTransport();
        $this->_email->transport($transport);


        $result = $this->_email->send();

        // HACK: Email headers are presented as a text blob, let's avoid parsing it
        $headers = ['from', 'sender', 'replyTo', 'readReceipt', 'returnPath', 'to', 'cc', 'subject'];
        $result['headersArray'] = $this->_email->getHeaders($headers);

        // HACK: Multi-part emails are presented as a text blob, parse the parts out
        $result['parts'] = $this->parseParts($result['message'], $this->_email->emailFormat());

        $this->reset();

        return $result;
    }

    protected function parseParts($message, $emailFormat)
    {
        $reflection = new ReflectionClass($this->_email);
        $property = $reflection->getProperty('_boundary');
        $property->setAccessible(true);
        $boundary = $property->getValue($this->_email);

        $parts = [];
        $segments = explode('--' . $boundary, $message);
        foreach ($segments as $segment) {
            preg_match("/(Content-Type: )([\w\/]+)/", $segment, $match);
            if (empty($match)) {
                continue;
            }

            $part = $match[2];
            $text = preg_replace('/Content-(Type|ID|Disposition|Transfer-Encoding):.*?\r\n/is', "", $segment);
            $parts[$part] = trim($text);
        }

        if (empty($parts)) {
            $part = 'text/html';
            if ($emailFormat === 'text') {
                $part = 'text/plain';
            }
            $parts[$part] = $message;
        }

        return $parts;
    }
}
