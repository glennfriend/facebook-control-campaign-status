<?php
namespace AppModule;

/**
 *
 */
class Shell extends Tool\BaseController
{
    /**
     *  設定 enable, disabled
     */
    protected function setting()
    {
        if (!attrib(0)) {
            pr(<<<'EOD'
------------------------------------------------------------
only arguments:
    id     (int)     get email by id
    "last" (string)  get last email

example:
    php get 10
    php get last
------------------------------------------------------------
EOD
);
            exit;
        }

echo '5243523452345234523';
exit;

        $id = attrib(0);
        $inboxes = new \Inboxes();

        // get by last
        if ('last'===$id) {
            $myInboxes = $inboxes->findInboxes([
                '_order'        => 'id,DESC',
                '_itemsPerPage' => 1
            ]);
            if (isset($myInboxes[0])) {
                $this->_show($myInboxes[0]);
            }
            else {
                pr('Inbox data not found');
            }
            exit;
        }

        // get by index
        $inbox = $inboxes->getInbox($id);
        if (!$inbox) {
            pr('Inbox data not found');
            exit;
        }
        $this->_show($inbox);
    }

    /**
     *
     */
    private function _show($inbox)
    {
        pr(
            \ConsoleHelper::table(
                ['subject', 'date', 'from', 'to', 'id'],
                [[
                    $inbox->getSubject(),
                    date('Y-m-d H:i:s', $inbox->getEmailCreateTime()),
                    $inbox->getFromEmail(),
                    $inbox->getToEmail(),
                    $inbox->getId()
                ]]
            )
        );
        pr($inbox->getContent());
        pr('<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');

        $data = $inbox->getProperty('data');
        $attachs = [];
        foreach ($data as $item) {
            if (!isset($item['name'])) {
                // 不是附件
                continue;
            }
            $attachs[] = $item['name'];
        }

        $count = count($attachs);
        if ($count>0) {
            pr("---------- attachments x {$count} ----------");
            foreach ($attachs as $name) {
                pr($name);
            }
        }

        pr('');
    }

}
