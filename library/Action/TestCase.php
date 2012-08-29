<?php

namespace Action;

class TestCase extends AbstractAction
{
    public function execute()
    {
        var_dump("executando tarefa da fila", $this->getParams());
        sleep(15);
        var_dump("terminou de executar");
    }
}