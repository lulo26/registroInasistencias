<?php header_admin($data); ?>
<main id="main" class="main">
<div class="pagetitle">
  <h1><?= $data['page_title']?></h1>
  <nav>
  <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url()?>/home">home</a></li>
          <li class="breadcrumb-item"><?= $data['page_title']?></li>
        </ol>
  </nav>
</div>
<div class="card">
<h1>Registro de RFID</h1>
    <form action="index.php" method="POST">
        <label for="codigo_rfid">Código RFID:</label>
        <input type="text" id="codigo_rfid" name="codigo_rfid" required>
        <button type="submit">Registrar</button>
    </form>
</div>
<?php footer_admin($data) ?> 