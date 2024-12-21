<?php

namespace App\Controllers;

use App\Controllers\Renstra\TujuanRenstra;
use App\Models\IndiSasaranRenstraModel;
use App\Models\IndiTujuanRenstraModel;
use App\Models\PeriodeRpjpd;
use App\Models\RpjpdModel;
use App\Models\RpjmdModel;
use App\Models\OpdModel;
use App\Models\SasaranRenstraModel;
use App\Models\TahapanModel;
use App\Models\TujuanRenstraModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    protected $rpjpd, $validation, $rpjmd, $opd, $tujuanrenstra, $inditujuanrenstra, $tahapan, $sasaranrenstra, $indisasaranrenstra;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->validation         = \Config\Services::validation();
        $this->rpjmd              = new RpjmdModel();
        $this->rpjpd              = new RpjpdModel();
        $this->opd                = new OpdModel();
        $this->tujuanrenstra      = new TujuanRenstraModel();
        $this->inditujuanrenstra  = new IndiTujuanRenstraModel();
        $this->tahapan            = new TahapanModel();
        $this->sasaranrenstra     = new SasaranRenstraModel();
        $this->indisasaranrenstra     = new IndiSasaranRenstraModel();

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
}
