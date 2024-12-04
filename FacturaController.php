<?php
require_once 'DAO/DAOFactura.php';
require_once 'DAO/DAODetalleFactura.php';
require_once 'BD/factura.php';
require_once 'BD/detalle_factura.php';

class FacturaController {
    private $daoFactura;
    private $daoDetalleFactura;

    public function __construct() {
        $this->daoFactura = new DAOFactura();
        $this->daoDetalleFactura = new DAODetalleFactura();
    }

    public function crearFacturaConDetalles($nombreCliente, $nombreVendedor, $moneda, $carrito) {
        $this->daoFactura->conectar();
        $this->daoDetalleFactura->conectar();

        try {
            // Calcular subtotal, impuesto y total
            $subtotal = 0;
            foreach ($carrito as $producto) {
                $subtotal += $producto['cantidad'] * $producto['precio_unitario'];
            }
            $impuesto = $subtotal * 0.15; // 15% de impuesto
            $total = $subtotal + $impuesto;

            // Crear factura
            $fecha_emision = date('Y-m-d');
            $numero_factura = rand(1000, 9999); // Número de factura aleatorio
            $factura = new Factura(null, $fecha_emision, $subtotal, $impuesto, $total, $numero_factura, null);

            if ($this->daoFactura->crearFactura($factura)) {
                $facturaId = $this->daoFactura->obtenerUltimoIdInsertado();

                // Crear detalles de la factura
                foreach ($carrito as $producto) {
                    $detalleFactura = new DetalleFactura(null, $producto['cantidad'], $producto['precio_unitario'], $facturaId, $producto['id']);
                    $this->daoDetalleFactura->crearDetalleFactura($detalleFactura);
                }

                // Retornar factura y detalles
                return [
                    "status" => "success",
                    "factura" => [
                        "id" => $facturaId,
                        "subtotal" => $subtotal,
                        "impuesto" => $impuesto,
                        "total" => $total,
                        "moneda" => $moneda,
                        "nombre_cliente" => $nombreCliente,
                        "nombre_vendedor" => $nombreVendedor,
                        "fecha_emision" => $fecha_emision
                    ],
                    "detalles" => $carrito
                ];
            } else {
                throw new Exception("Error al crear la factura");
            }
        } catch (Exception $e) {
            return [
                "status" => "error",
                "mensaje" => $e->getMessage()
            ];
        } finally {
            $this->daoFactura->desconectar();
            $this->daoDetalleFactura->desconectar();
        }
    }
}
?>
