<?php

namespace Action;

class MakePreview extends AbstractAction
{
    public function execute()
    {
        $origin = new \File\Info($this->getParams('file'));

        try {
            $resizer = new \Media\Resizer($origin);
            $resizer->makePreview();
            $resizer->makeThumb();
        } catch (\Exception $exception) {
            syslog(LOG_ERR, $exception->getMessage());
        }
    }
}