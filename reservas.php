<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Metodo nao permitido']);
  exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'JSON invalido']);
  exit;
}

$nome = trim($data['nome'] ?? '');
$whatsapp = trim($data['whatsapp'] ?? '');
$dataPretendida = trim($data['data'] ?? '');
$pessoas = trim((string)($data['pessoas'] ?? ''));

if ($nome === '' || $whatsapp === '' || $dataPretendida === '' || $pessoas === '') {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Campos obrigatorios ausentes']);
  exit;
}

$csvPath = __DIR__ . DIRECTORY_SEPARATOR . 'reservas.csv';
$columns = ['recebido_em', 'nome', 'whatsapp', 'data', 'pessoas'];
$needsHeader = !file_exists($csvPath) || filesize($csvPath) === 0;

$file = fopen($csvPath, 'ab');
if (!$file) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Nao foi possivel abrir o CSV']);
  exit;
}

flock($file, LOCK_EX);

if ($needsHeader) {
  fputcsv($file, $columns, ';');
}

fputcsv($file, [
  date('c'),
  $nome,
  $whatsapp,
  $dataPretendida,
  $pessoas
], ';');

flock($file, LOCK_UN);
fclose($file);

echo json_encode(['ok' => true]);
