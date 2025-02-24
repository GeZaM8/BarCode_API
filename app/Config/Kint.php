<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use Kint\Kint as KintDebugger;

class Kint extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Kint
     * --------------------------------------------------------------------------
     *
     * Konfigurasi untuk Kint debugger.
     *
     * @var array
     */
    public $plugins = [];

    /**
     * Tema yang digunakan.
     * Pilihan: 'original.css', 'solarized.css', 'solarized-dark.css', 'aante-light.css'
     *
     * @var string
     */
    public $theme = 'original.css';

    /**
     * Mengatur tampilan default Kint
     * Pilihan: 'rich', 'plain', 'cli'
     *
     * @var string
     */
    public $maxDepth = 6;
    public $displayCalledFrom = true;
    public $expanded = false;

    /**
     * Konfigurasi renderer
     */
    public function __construct()
    {
        parent::__construct();

        if (class_exists(KintDebugger::class)) {
            KintDebugger::$depth_limit = $this->maxDepth;
            KintDebugger::$display_called_from = $this->displayCalledFrom;
            KintDebugger::$expanded = $this->expanded;
            
            // Nonaktifkan Kint di production
            if (ENVIRONMENT === 'production') {
                KintDebugger::$enabled_mode = false;
            }
        }
    }
}
