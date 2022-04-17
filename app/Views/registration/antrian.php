<?= $this->extend('layout/template'); ?>

<?= $this->section('sidebar'); ?>
<?= $this->include('registration/sidebar'); ?>
<?= $this->endsection(); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Antrian Pasien</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/registration">Pendaftaran</a></li>
                        <li class="breadcrumb-item active">Antrian Pasien</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Antrian Pasien</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Rekam Medis</th>
                                        <th>Nama Pasien</th>
                                        <th>status</th>
                                        <th>No Antrian</th>
                                        <th>Waktu Pendaftaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1 ?>
                                    <?php foreach ($antrian as $row) : ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $row['no_rekam_medis']; ?></td>
                                            <td><?= $row['nama_pasien']; ?></td>
                                            <td><?= $row['status']; ?></td>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= $row['created_at']; ?></td>
                                        </tr>
                                        <?php $no++ ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?= $pager->links() ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<?= $this->endsection(); ?>