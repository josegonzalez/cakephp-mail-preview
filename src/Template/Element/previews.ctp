<?php foreach ($mailPreviews as $mailPreview) : ?>
    <h3><?= $mailPreview->name() ?></h3>
    <table cellpadding="0" cellspacing="0">
        <tbody>
        <?php foreach ($mailPreview->getEmails() as $email) : ?>
            <tr>
                <td>
                    <?php
                    echo $this->Html->link($email, [
                        'controller' => 'MailPreview',
                        'action' => 'email',
                        $mailPreview->name(),
                        $email,
                    ]);
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>
