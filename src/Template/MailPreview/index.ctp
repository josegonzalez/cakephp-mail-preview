<ul>
<?php
foreach ($mailPreviews as $mailPreview) {
    $previewName = $mailPreview->previewName();
    echo $this->Html->tag('h3', $previewName, ['escape' => false]);

    foreach ($mailPreview->getEmails() as $email) {
        $link = $this->Html->link($email, [
            'controller' => 'MailPreview',
            'action' => 'email',
            $previewName,
            $email,
        ]);
        echo $this->Html->tag('li', $link, ['escape' => false]);
    }
}
?>
</ul>
