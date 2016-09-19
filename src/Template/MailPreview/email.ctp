<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <style type="text/css">
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
        }

        header {
            background: white;
            border-bottom: 1px solid #dedede;
            font: 12px "Lucida Grande", sans-serif;
            height: 100px;
            margin: 0;
            overflow: hidden;
            padding: 10px 0 0 0;
            width: 100%;
        }

        dl {
            margin: 0 0 10px 0;
            padding: 0;
        }

        dt {
            width: 80px;
            padding: 1px;
            float: left;
            clear: left;
            text-align: right;
            color: #7f7f7f;
        }

        dd {
            margin-left: 90px; /* 80px + 10px */
            padding: 1px;
        }

        dd:empty:before {
            content: "\00a0"; // &nbsp;
        }

        iframe.messageBody {
            border: 0;
            height: calc(100vh - 100px);
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <dl>
            <?php if (!empty($email['headersArray']['SMTP-From'])) : ?>
                <dt>SMTP-From:</dt>
                <dd><?php echo $email['headersArray']['SMTP-From'] ?></dd>
            <?php endif; ?>

            <?php if (!empty($email['headersArray']['SMTP-To'])) : ?>
                <dt>SMTP-To:</dt>
                <dd><?php echo $email['headersArray']['SMTP-To'] ?></dd>
            <?php endif; ?>

            <dt>From:</dt>
            <dd><?php echo $email['headersArray']['From'] ?></dd>

            <?php if (!empty($email['headersArray']['Reply-To'])) : ?>
                <dt>Reply-To:</dt>
                <dd><?php echo $email['headersArray']['reply-to'] ?></dd>
            <?php endif; ?>

            <dt>To:</dt>
            <dd><?php echo $email['headersArray']['To'] ?></dd>

            <?php if (!empty($email['headersArray']['Cd'])) : ?>
                <dt>CC:</dt>
                <dd><?php echo $email['headersArray']['Cc'] ?></dd>
            <?php endif; ?>

            <dt>Date:</dt>
            <dd><?php echo 'Time.current.rfc2822' ?></dd>

            <dt>Subject:</dt>
            <dd><strong><?php echo $email['headersArray']['Subject'] ?></strong></dd>

            <?php if (!empty($email['headersArray']['Attachments'])) : ?>
                <dt>Attachments:</dt>
                <dd>
                <?php foreach ($email['headersArray']['Attachments'] as $a) : ?>
                    <?php $filename = $a.respond_to('original_filename') ? $a->original_filename : $a->filename; ?>
                    <?php echo $this->Html->link($filename, "data:application/octet-stream;charset=utf-8;base64,#{Base64.encode64(a.body.to_s)}", ['download' => 'filename']); ?>
                <?php endforeach ?>
                </dd>
            <?php endif; ?>

            <?php if (!empty($email['parts'])) : ?>
            <dd>
                <select onchange="formatChanged(this);">
                    <option <?php echo (\Cake\Utility\Hash::get($this->request->query, 'part', $part) == 'text/html') ? 'selected' : ''; ?> value="?part=text%2Fhtml">View as HTML email</option>
                    <option <?php echo (\Cake\Utility\Hash::get($this->request->query, 'part', $part) == 'text/plain') ? 'selected' : ''; ?> value="?part=text%2Fplain">View as plain-text email</option>
                </select>
            </dd>
            <?php endif; ?>
        </dl>
    </header>

    <?php if (!empty($part)) : ?>
        <iframe seamless name="messageBody" class="messageBody" src="?part=<?php echo $part; ?>"></iframe>
    <?php else : ?>
        <p>You are trying to preview an email that does not have any content.</p>
    <?php endif; ?>

    <script>
        function formatChanged(form) {
            var part_name = form.options[form.selectedIndex].value
            var iframe =document.getElementsByName('messageBody')[0];
            iframe.contentWindow.location.replace(part_name);

            if (history.replaceState) {
                var url    = location.pathname.replace(/\.(txt|html)$/, '');
                var format = /html/.test(part_name) ? '?part=text%2Fhtml' : '?part=text%2Fplain';
                window.history.replaceState({}, '', url + format);
            }
        }
    </script>

</body>
</html>
