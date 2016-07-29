<?php 
namespace YohKenn\JasperReportBundle\Services;

use Jaspersoft\Client\Client;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;

class ClientService 
{

	private $report_client;

	private $jasperClient;

	private $container;

	private $connected;

	private $jrs_host;

	private $jrs_prot;

	private $jrs_base;

	private $jrs_username;

	private $jrs_password;

	private $jrs_org_id;

	public function __construct(Container $container) {
        $this->container = $container;

        $this->connected = false;
    }


    public function init() {
 
        $return = $this->connect();

        return $return;
    }

    public function connect() {
        if(@fsockopen($this->jrs_host,$this->jrs_port)){
        	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $this->jrs_host . ":" . $this->jrs_port . "/" . $this->jrs_base ;
            $this->jasperClient = new Client($url, $this->jrs_username, $this->jrs_password, $this->jrs_org_id);
            $this->jasperClient->setRequestTimeout(60); 

            $this->connected = true;
        } else {
            $this->connected = false;
        }

        return $this->connected;
    }

    public function export($format,$params,$reportUnit)
	{
		if(!$this->isConnected()){
			$response = new Response("Not currently connected to the Report Server");
			return $response;
		}

		if(isset($format)){
			$reportService = $this->jasperClient->reportService();

			switch($format){
				case 'html':
					$report = $reportService->runReport($reportUnit, $format, null, null, $params);
					$response = new Response($report);
					break;
				case 'xlsx':
				case 'xls':
				case 'rtf':
				case 'csv':
				case 'odt':
				case 'xml':
				case 'docx':
				case 'ods':
				case 'pptx':
				case 'pdf':
					$disposition = ($format == 'pdf') ? "inline" : "attachment";

					$report = $reportService->runReport($reportUnit, $format, null, null, $params);
					$response = new Response($report);

					$response->headers->set('Cache-Control', 'must-revalidate');
					$response->headers->set('Pragma', 'public');
					$response->headers->set('Content-Description', 'File Transfer');
					$response->headers->set('Content-Disposition', $disposition.'; filename=report.'.$format);
					$response->headers->set('Content-Transfer-Encoding', 'binary');
					$response->headers->set('Content-Length', strlen($report));
					$response->headers->set('Content-Type', 'application/'.$format);
					break;
				default:
					$response = new Response("Sorry file format ".$format." is not supported.");
					break;
			}
		}else{
			$response = new Response("Please provide file format.");
		}
		
		return $response;

	}

	public function isConnected() {
        return $this->connected;
    }

    ////////////////////////
    // GETTERS AND SETTER //
    ////////////////////////
    
    public function getJasperClient() {
        return $this->jasperClient;
    }

    public function setJasperClient(JasperClient\Client\Client $jasperClient) {
        $this->jasperClient = $jasperClient;
        return $this;
    }

    public function setJrsHost($jrs_host){
    	$this->jrs_host = $jrs_host;
        return $this;
    }

    public function getJrsHost(){
    	return $this->jrs_host;
    }

    public function setJrsPort($jrs_port){
    	$this->jrs_port = $jrs_port;
        return $this;
    }

    public function getJrsPort(){
    	return $this->jrs_port;
    }

    public function setJrsBase($jrs_base){
    	$this->jrs_base = $jrs_base;
        return $this;
    }

    public function getJrsBase(){
    	return $this->jrs_base;
    }

    public function setJrsUsername($jrs_username){
    	$this->jrs_username = $jrs_username;
        return $this;
    }

    public function getJrsUsername(){
    	return $this->jrs_username;
    }

    public function setJrsPassword($jrs_password){
    	$this->jrs_password = $jrs_password;
        return $this;
    }

    public function getJrsPassword(){
    	return $this->jrs_password;
    }

    public function setJrsOrgId($jrs_org_id){
    	$this->jrs_org_id = $jrs_org_id;
        return $this;
    }

    public function getJrsOrgId(){
    	return $this->jrs_org_id;
    }

}
