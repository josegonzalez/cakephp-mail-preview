<?php
namespace Josegonzalez\MailPreview\Mailer\Preview;

use Cake\Mailer\MailerAwareTrait;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class MailPreview
{
    use MailerAwareTrait;

    public function find($name)
    {
        if ($this->validPreview($name)) {
            return $name;
        }

        return false;
    }

    public function getEmails()
    {
        $emails = [];
        foreach (get_class_methods($this) as $methodName) {
            if (!$this->validPreview($methodName)) {
                continue;
            }

            $emails[] = $methodName;
        }

        return $emails;
    }

    public function previewName()
    {
        $classname = get_class($this);
        if ($pos = strrpos($classname, '\\')) {
            return substr($classname, $pos + 1);
        }

        return $pos;
    }

    protected function validPreview($name)
    {
        if (empty($name)) {
            return false;
        }

        $baseClass = new ReflectionClass(get_class());
        if ($baseClass->hasMethod($name)) {
            return false;
        }

        try {
            $method = new ReflectionMethod($this, $name);
        } catch (ReflectionException $e) {
            return false;
        }

        return $method->isPublic();
    }
}
