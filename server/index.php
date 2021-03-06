<?php

namespace Tests;
require '../vendor/autoload.php';

use Signati\Core\CFDI;
use Signati\Core\Complementos\Iedu;
use Signati\Core\Tags\Concepto;
use Signati\Core\Tags\Emisor;
use Signati\Core\Tags\Impuestos;
use Signati\Core\Tags\Receptor;
use Signati\Core\Tags\Relacionado;

$cfdi = new CFDI([
    'Serie' => 'A',
    'Folio' => 'A0103',
    'Fecha' => '2018-02-02T11:36:17',
    'FormaPago' => '01',
    // 'NoCertificado' => '30001000000300023708',
    'SubTotal' => '4741.38',
    'Moneda' => 'MXN',
    'TipoCambio' => '1',
    'Total' => '5500.00',
    'TipoDeComprobante' => 'I',
    'MetodoPago' => 'PUE',
    'LugarExpedicion' => '64000',
], '3.3');
$relacion = new Relacionado('01');
$relacion->addRelacion('asdasdsad');
$relacion->addRelacion('dalia');
$cfdi->relacionados($relacion);

$emisor = new Emisor([
    'Rfc' => "XXXXXX",
    'Nombre' => "signait",
    'RegimenFiscal' => "602"
]);
$cfdi->emisor($emisor);

$receptor = new Receptor([
    'Rfc' => "asdsad",
    'Nombre' => "amir",
    'ResidenciaFiscal' => "1231",
    'NumRegIdTrib' => "1231",
    'UsoCFDI' => "012"
]);
$cfdi->receptor($receptor);


$concepto = new Concepto([
    'ClaveProdServ' => '3243',
    'NoIdentificacion' => '234234',
    'Cantidad' => '1',
    'ClaveUnidad' => 'Pieza',
    'Unidad' => '1',
    'Descripcion' => 'asdad',
    'ValorUnitario' => '322332',
    'Importe' => '00',
    'Descuento' => '00',
]);
//$concepto->complemento();

$concepto->traslado([
    'Base' => '',
    'Impuesto' => '',
    'TipoFactor' => '',
    'TasaOCuota' => '',
    'Importe' => '',
]);

$concepto->retencion([
    'Base' => '',
    'Impuesto' => '',
    'TipoFactor' => '',
    'TasaOCuota' => '',
    'Importe' => '',
]);
$cfdi->concepto($concepto);

$concepto2 = new Concepto([
    'ClaveProdServ' => '3243',
    'NoIdentificacion' => '234234',
    'Cantidad' => '1',
    'ClaveUnidad' => 'Pieza',
    'Unidad' => '1',
    'Descripcion' => 'asdad',
    'ValorUnitario' => '322332',
    'Importe' => '00',
    'Descuento' => '00',
]);
$iedu = new Iedu([
    'version' => '1.0',
    'autRVOE' => '201587PRIM',
    'CURP' => 'EJEMPLOGH101004HQRRRN',
    'nivelEducativo' => 'Primaria',
    'nombreAlumno' => 'ejemplo garcia correa',
    'rfcPago' => 'XAXX010101000',
]);
$concepto2->complemento($iedu);
$cfdi->concepto($concepto2);

$impuest = new Impuestos([
    'TotalImpuestosRetenidos' => '',
    'TotalImpuestosTrasladados' => '',
]);
$impuest->traslados([
    'Impuesto' => '',
    'TipoFactor' => '',
    'TasaOCuota' => '',
    'Importe' => '',
]);
$impuest->traslados([
    'Impuesto' => '',
    'TipoFactor' => '',
    'TasaOCuota' => '',
    'Importe' => '',
]);

$impuest->traslados([
    'Impuesto' => '',
    'TipoFactor' => '',
    'TasaOCuota' => '',
    'Importe' => '',
]);

$impuest->retenciones([
    'Impuesto' => '',
    'TipoFactor' => '',
    'TasaOCuota' => '',
    'Importe' => '',
]);

$impuest->retenciones([
    'Impuesto' => '',
    'TipoFactor' => '',
    'TasaOCuota' => '',
    'Importe' => '',
]);
$cfdi->impuesto($impuest);
$cer = join([dirname(__DIR__), '/server/certificados/LAN7008173R5.cer']);
$key = join([dirname(__DIR__), '/server/certificados/LAN7008173R5.key']);
$cfdi->certificar($cer);

$cfdi->sellar($key, '12345678a');
if (!true) {

    echo '<pre>';
    print_r(json_encode($cfdi->getArray(), JSON_PRETTY_PRINT));
    echo '</pre>';
    exit();
} else {


    header("Content-type: application/xhtml+xml");
    echo $cfdi->getDocument();
    //var_dump(json_encode($cfdi->certificar('amir')));
}
//echo 'Escrito: ' . $doc->save("./test.xml") . ' bytes'; // Escrito: 72 bytes