<?php

namespace Action;

class MakePreview extends AbstractAction
{
    public function execute()
    {
        $origin = new \File\Info($this->getParams('file'));

        $resizer = new \Media\Resizer(new \Enum\MediaOperation(\Enum\MediaOperation::RESIZE), $origin);
        $resizer->makePreview();
        $resizer->makeThumb();
    }
}