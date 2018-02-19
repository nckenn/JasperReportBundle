# JasperReportBundle

The JasperReportBundle requires jaspersoft/rest-client and provides an JasperReport-Client as service in the Symfony service container.

## Installation

1 Add bundle to <code>composer.json</code>:
```shel
    composer require yoh/symfony-jasper-report-bundle
```
2 Register bundle in <code>app/AppKernel.php</code>:
```php
    $bundle = [
            ...
    		new Yoh\JasperReportBundle\YohJasperReportBundle(),
            ...
    ];
```
3 Add parameter to <code>app/config/config.yml</code>
```yml
    yoh_jasper_report:
        jrs_host:      "%jrs_host%"
        jrs_port:      "%jrs_port%"
        jrs_base:      "%jrs_base%"
        jrs_username:  "%jrs_username%"
        jrs_password:  "%jrs_password%"
        jrs_org_id:    "%jrs_org_id%"
```
4 Add a dummy configuration in <code>app/config/parameters.yml.dist</code>
```yml
    jrs_host:      127.0.0.1
    jrs_port:      8080
    jrs_base:      jasperserver
    jrs_username:  jasperadmin
    jrs_password:  jasperadmin
    jrs_org_id:    null
```
5 Add your own configuration in <code>app/config/parameters.yml</code>

## Usage

You can now access the <code>Client</code> object via the Symfony service <code>yoh.jasper.report</code>:
```php
    $client = $this->get('yoh.jasper.report')->getJasperClient();
```
Using Report Service :
```php
    $reportService = $client()->reportService();
```

So a controller giving back a pdf-report would look like
```php
    public function reportAction(Request $request)
    {
    	$format = "pdf";
        $reportUnit = "/reports/sampleReport";
        $params = array(
            "Custom Label 1" => "Custom Value 1",
            "Custom Label 2" => "Custom Value 2"
        );

        return $this->get('yoh.jasper.report')->generate($reportUnit, $format, $params);
    }
```
