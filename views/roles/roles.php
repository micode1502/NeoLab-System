<div class="recent-orders">
    <div class="title-table d-flex justify-content-between mb-3">
        <h2><?php echo $data["title"]; ?></h2>
        <button type="button" class="btn btn-outline-success n-registro" data-bs-toggle="modal" data-bs-target="#modal-roles" data-bs-backdrop="static" data-bs-keyboard="false">
            <i class="fa-solid fa-plus"></i> NUEVO REGISTRO
        </button>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>State</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="rolesTable">

        </tbody>
    </table>

</div>

<div class="modal fade" id="modal-roles" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <h4 class="modal-title" id="title">Editar Permisos</h4>
                    <hr>
                </div>
            </div>
            <form id="formRole" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Imagen</label>
                        <input type="hidden" id="txtImg" name="txtImg">
                        <div class="col-sm-7">
                            <div class="custom-file">
                                <input type="file" class="form-control-file" id="file" name="file">
                                <label class="custom-file-label" for="customFile" id="customFile"></label>
                            </div>
                            <small class="text-danger "><b id="errFile"></b></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Nombre</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtName" id="txtName" class="form-control">
                            <small class="text-danger "><b id="errTxtName"></b></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Rol</label>
                        <div class="col-sm-7">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkState" name="chkState" checked>
                                <label class="form-check-label" for="chkState">
                                    Activo/inactivo
                                </label>
                            </div>
                            <small class="text-danger "><b id="errChkState"></b></small>
                        </div>
                    </div>
                </div>
                <small class="text-danger "><b id="errException"></b></small>
                <div class="modal-footer justify-content-center">
                    <a href="" class="btn btn-width btn-secondary btn-flat">CANCELAR</a>
                    <button type="button" class="btn btn-width btn-success btn-flat" onclick="registerRole()" id="btnRegister">REGISTRAR DATOS</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal form-modal" id="modal-permissions" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title">Nuevo Registro</h4>
            </div>
            <form id="formPermission" autocomplete="off">
                <input type="hidden" name="id" id="id" class="form-control">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Módulos</th>
                                    <th class="text-center" scope="col">Lectura</th>
                                    <th class="text-center" scope="col">Registrar</th>
                                    <th class="text-center" scope="col">Actualizar</th>
                                    <th class="text-center" scope="col">Eliminar</th>
                                    <th class="text-center" scope="col">Imprimir</th>
                                </tr>
                            </thead>
                            <tbody id="tblPermissions">

                            </tbody>
                        </table>
                    </div>
                </div>
                <small class="text-danger "><b id="errException"></b></small>
                <div class="modal-footer justify-content-center">
                    <a href="" class="btn btn-width btn-secondary btn-flat">CANCELAR</a>
                    <button type="button" class="btn btn-width btn-success btn-flat" id="btnPerms">REGISTRAR PERMISOS</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    $(document).ready(function() {
        listRoles();
        getAccessCRUD();
    });

    function getAccessCRUD() {
        $.ajax({
            url: "<?php echo BASE_URL; ?>roles/getAccessCRUD",
            type: "POST",
            success: function(response) {
                var jsonData = JSON.parse(response);
                /* console.log(jsonData); */
                if (jsonData.access && jsonData.access.r == 0) {
                    $(".recent-orders table").css("display", "none");
                }
                if (jsonData.access && jsonData.access.c == 0) {
                    $(".recent-orders .title-table .n-registro").css("display", "none");
                }
                if (jsonData.access && jsonData.access.u == 0) {
                    $(".recent-orders table td .btn-edit").css("display", "none");
                }
                if (jsonData.access && jsonData.access.d == 0) {
                    $(".recent-orders table td .btn-delete").css("display", "none");
                }
                /* if(jsonData.access.u==0 && jsonData.access.d==0){
                    $(".recent-orders table tr th").last().css("display","none");
                } */
            }
        })
    }

    function listRoles() {
        $.ajax({
            url: "<?php echo BASE_URL ?>roles/showRoles",
            type: "POST",
            success: function(response) {
                var data = JSON.parse(response);
                /* Not authorized - Server*/
                if (data.statusCode == 405) {
                    /* $("#modal-perfiles").modal('hide'); */
                    if (data.errors.notAuthorized) {
                        Swal.fire({
                            width: 450,
                            timer: 6000,
                            timerProgressBar: true,
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors.notAuthorized,
                        }).then((result) => {
                            window.location.href = "<?php echo BASE_URL; ?>profile";
                        });
                    }
                } /* Authorized - Server*/
                else {
                    let cont = 0;
                    filas = "";
                    $.each(data.roles, function(idx, val) {
                        cont++;
                        filas +=
                            "<tr>" +
                            "<td>" + cont + "</td>" +
                            "<td class='center-cell'> <img src='public/roles/" + val.image + "' width='50' height='50'></td>" +
                            "<td>" +
                            val.name +
                            "</td>" +
                            "<td>" +
                            (val.state == '1' ? "Activo" : "Inactivo") +
                            "</td>" +
                            "<td>" +
                            "<button type='button' class='option-buttons' data-toggle='modal' data-target='#modal-permissions' data-backdrop='static' data-keyboard='false' onclick='setupPermissions(" + val.idRole + ")'><i class='fa-solid fa-chalkboard-teacher'></i></button>" +
                            "<button type='button' class='option-buttons btn-edit' data-toggle='modal' data-target='#modal-roles' data-backdrop='static' data-keyboard='false' onclick='viewRole(" + val.idRole + ")'><i class='fa-solid fa-pen'></i></button>" +
                            "<button type='button' class='option-buttons btn-delete' onclick='deleteRole(" + val.idRole + ")'><i class='fa-solid fa-trash'></i></button>" +
                            "</tr>";
                    });

                    $("#rolesTable").html(filas);
                }

            },
        });
    }


    function registerRole() {
        $.ajax({
            url: "<?php echo BASE_URL; ?>roles/registerRole",
            type: "POST",
            data: new FormData(document.getElementById('formRole')),
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {

                var data = JSON.parse(response);

                if (data.statusCode == 200) {
                    $("#modal-roles").modal('hide');
                    Swal.fire({
                        width: 450,
                        timer: 6000,
                        timerProgressBar: true,
                        title: "Confirmación",
                        text: "Usuario registrado correctamente",
                        icon: "success",
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {

                        window.location.href = '<?php echo BASE_URL ?>roles';

                    });
                } /* Not authorized - Server*/
                else if (data.statusCode == 405) {
                    $("#modal-modules").modal('hide');
                    if (data.errors.notAuthorized) {
                        Swal.fire({
                            width: 450,
                            timer: 6000,
                            timerProgressBar: true,
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors.notAuthorized,
                        });
                    }
                } else if (data.statusCode == 500) {
                    $("#modal-roles").modal('show');

                    $("#errTxtName").text(data.errors.name ? data.errors.name : "");

                    $("#errFile").text(data.errors.image ? data.errors.image : "");

                }

            }
        });
    }

    function viewRole(id) {
        $("#title").text("Actualizar Registro");
        $.ajax({
            url: "<?php echo BASE_URL ?>roles/showRole/" + id,
            type: "POST",
            success: function(response) {

                var data = JSON.parse(response);

                $("#txtName").val(data.role.name);
                $("#customFile").text(data.role.image);

                if (data.role.state == 1) {
                    $("#chkState").prop("checked", true);
                } else {
                    $("#chkState").prop("checked", false);
                }

                $("#txtImg").val(data.role.image);

                $("#btnRegister").text("Actualizar Datos");
                $("#btnRegister").attr("onclick", "updateRole(" + id + ")");
                $("#modal-roles").modal('show');
            }
        });
    }

    function updateRole(id) {
        $.ajax({
            url: "<?php echo BASE_URL; ?>roles/updateRole/" + id,
            type: "POST",
            data: new FormData(document.getElementById('formRole')),
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.statusCode == 200) {
                    $("#modal-roles").modal('hide');
                    listRoles();
                    Swal.fire({
                        width: 450,
                        timer: 6000,
                        timerProgressBar: true,
                        title: "Confirmación",
                        text: "Datos actualizados correctamente",
                        icon: "success",
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {

                        window.location.href = '<?php echo BASE_URL ?>roles';

                    });
                } /* Not authorized - Server*/
                else if (data.statusCode == 405) {
                    $("#modal-perfiles").modal('hide');
                    if (data.errors.notAuthorized) {
                        Swal.fire({
                            width: 450,
                            timer: 6000,
                            timerProgressBar: true,
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors.notAuthorized,
                        });
                    }
                } /* Authorized - Server*/
                else if (data.statusCode == 500) {
                    $("#modal-roles").modal('show');

                    $("#errTxtName").text(data.errors.name ? data.errors.name : "");

                    $("#errFile").text(data.errors.image ? data.errors.image : "");
                }
            }
        });
    }

    function deleteRole(id) {

        Swal.fire({
            width: 450,
            title: 'Confirmación',
            text: "¿Estás seguro de eliminar el usuario?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo BASE_URL ?>roles/deleteRole/' + id,
                    type: 'POST',
                    success: function(response) {
                        var data = JSON.parse(response);
                        /* Not authorized - Server*/
                        if (data.statusCode == 405) {
                            $("#modal-perfiles").modal('hide');
                            if (data.errors.notAuthorized) {
                                /* $("#errorFile").text(jsonData.errors.notAuthorized); */
                                Swal.fire({
                                    width: 450,
                                    timer: 6000,
                                    timerProgressBar: true,
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.errors.notAuthorized,
                                });
                            }
                        } /* Authorized - Server*/
                        else {
                            listRoles();
                            Swal.fire({
                                width: 450,
                                timer: 6000,
                                timerProgressBar: true,
                                title: "Confirmación",
                                text: data.message,
                                icon: "success",
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    }
                });
            }
        })
    }

    function setupPermissions(idRole) {
        $.ajax({
            url: '<?php echo BASE_URL ?>roles/setupPermissions/' + idRole,
            type: 'POST',
            success: function(response) {
                var jsonDate = JSON.parse(response);
                $("#btnPerms").attr("onclick", "registerPermissions('" + idRole + "')");
                $("#tblPermissions").html(jsonDate.modules);
                $("#modal-permissions").modal('show');
            }
        });
    }

    function registerPermissions(idRole) {
        $.ajax({
            url: "<?php echo BASE_URL; ?>roles/updatePermissions/" + idRole,
            type: "POST",
            data: new FormData(document.getElementById('formPermission')),
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var data = JSON.parse(response);
                listRoles();
                Swal.fire({
                    width: 450,
                    timer: 6000,
                    timerProgressBar: true,
                    title: "Confirmación",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: 'Aceptar'
                }).then((result) => {

                    window.location.href = '<?php echo BASE_URL ?>roles';

                });
            }
        });
    }
</script>