<div class="recent-orders">
    <div class="title-table d-flex justify-content-between mb-3">
        <h2><?php echo $data["title"]; ?></h2>
        <button type="button" class="btn btn-outline-success n-registro" data-bs-toggle="modal" data-bs-target="#modal-user" data-bs-backdrop="static" data-bs-keyboard="false">
            <i class="fa-solid fa-plus"></i> EDITAR CREDENCIALES
        </button>
    </div>



    <div class="row">
        <div class="col-md-3 text-center">
            <img class="img-fluid rounded-circle mb-3" src="public/users/<?php echo $data["user"]["avatar"] ?>" alt="Profile Picture">
            <h2 class="mb-0"><?php echo $data["user"]["username"] ?></h2>
            <p class="text-muted"><?php echo $data["user"]["role"] ?></p>
        </div>
        <div class="col-md-9">
            <div class="border rounded p-4 h-100">
                <h3 class="mb-4">Profile Information</h3>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-4"><strong>Nombre: </strong><?php echo $data["user"]["name"] ?></p>
                        <p class="mb-4"><strong>Apellido: </strong><?php echo $data["user"]["lastName"] ?></p>
                        <p class="mb-4"><strong>DNI: </strong><?php echo $data["user"]["dni"] ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-4"><strong>Fecha de nacimiento: </strong><?php echo $data["user"]["bornDate"] ?></p>
                        <p class="mb-4"><strong>Email: </strong><?php echo $data["user"]["email"] ?></p>
                        <p class="mb-4"><strong>Teléfono: </strong><?php echo $data["user"]["number"] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-user" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <h4 class="modal-title" id="title">Editar Credenciales</h4>
                    <hr>
                </div>
            </div>
            <form id="formUser" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Usuario</label>
                        <div class="col-sm-7">
                            <input type="text" value="<?php echo $data['user']['username'] ?>" name="txtUsername" id="txtUsername" class="form-control">
                            <small class="text-danger "><b id="errTxtUsername"></b></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Contraseña</label>
                        <div class="col-sm-7">
                            <input type="password" name="txtPassword" id="txtPassword" class="form-control">
                            <small class="text-danger "><b id="errTxtPassword"></b></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Avatar</label>
                        <input type="hidden" value="<?php echo $data['user']['avatar'] ?>" id="txtImg" name="txtImg">
                        <div class="col-sm-7">
                            <div class="custom-file">
                                <input type="file" class="form-control-file" id="file" name="file">
                                <label class="custom-file-label" for="customFile" id="customFile"><?php echo $data['user']['avatar'] ?></label>
                            </div>
                            <small class="text-danger "><b id="errFile"></b></small>
                        </div>
                    </div>
                </div>
                <small class="text-danger "><b id="errException"></b></small>
                <div class="modal-footer justify-content-center">
                    <a href="" class="btn btn-width btn-secondary btn-flat">CANCELAR</a>
                    <button type="button" class="btn btn-width btn-success btn-flat" onclick="updateUser(<?php echo $data['user']['id'] ?>)" id="btnRegister">ACTUALIZAR DATOS</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function updateUser(id) {
        $.ajax({
            url: "<?php echo BASE_URL; ?>profile/updateUser/" + id,
            type: "POST",
            data: new FormData(document.getElementById('formUser')),
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.statusCode == 200) {
                    $("#modal-user").modal('hide');
                    Swal.fire({
                        width: 450,
                        timer: 6000,
                        timerProgressBar: true,
                        title: "Confirmación",
                        text: "Datos actualizados correctamente",
                        icon: "success",
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {

                        window.location.href = '<?php echo BASE_URL ?>profile';

                    });
                } else if (data.statusCode == 500) {
                    $("#modal-user").modal('show');
                    $("#errFile").text(data.errors.image ? data.errors.image : "");
                    $("#errTxtUsername").text(data.errors.username ? data.errors.username : "");
                    $("#errTxtPassword").text(data.errors.password ? data.errors.password : "");
                    $("#errException").text(data.errors.exception ? data.errors.exception : "");
                }
            }
        });
    }
</script>