<?php
namespace ZFCompat\Module;

interface Configurable {
    public function getConfig();
    public function setConfig($cfg);
}
