<div class="recent-orders">
    <div class="title-table d-flex justify-content-between mb-3">
        <h2><?php echo $data["title"]; ?></h2>
        <button type="button" class="btn btn-outline-success n-registro" data-bs-toggle="modal" data-bs-target="#modal-user" data-bs-backdrop="static" data-bs-keyboard="false">
            <i class="fa-solid fa-plus"></i> NUEVO REGISTRO
        </button>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="usersTable">

        </tbody>
    </table>

</div>

<div class="modal fade" id="modal-user" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <h4 class="modal-title" id="title">Nuevo Registro</h4>
                    <hr>
                </div>
            </div>
            <form id="formUser" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Nombre</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtName" id="txtName" class="form-control">
                            <small class="text-danger "><b id="errTxtName"></b></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Apellidos</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtLastName" id="txtLastName" class="form-control">
                            <small class="text-danger "><b id="errTxtLastName"></b></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Avatar</label>
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
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Dni</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtDni" id="txtDni" class="form-control">
                            <small class="text-danger "><b id="errTxtDni"></b></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Correo</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtMail" id="txtMail" class="form-control">
                            <small class="text-danger "><b id="errTxtMail"></b></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Teléfono</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtPhone" id="txtPhone" class="form-control">
                            <small class="text-danger "><b id="errTxtPhone"></b></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Género</label>
                        <div class="col-sm-7">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rbGender" id="genderMale" value="1">
                                <label class="form-check-label" for="genderMale">Masculino</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rbGender" id="genderFemale" value="2">
                                <label class="form-check-label" for="genderFemale">Femenino</label>
                            </div>
                            <small class="text-danger "><b id="errRbGender"></b></small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Fecha Nac.</label>
                        <div class="col-sm-7">
                            <input type="date" name="dateBorn" id="dateBorn" class="form-control">
                            <small class="text-danger "><b id="errDateBorn"></b></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Rol</label>
                        <div class="col-sm-7">
                            <select name="cboRole" id="cboRole" class="form-control">
                                <?php foreach ($data["roles"] as $row) : ?>
                                    <option value="<?php echo $row["idRole"] ?>"> <?php echo $row["name"] ?> </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger "><b id="errCboRole"></b></small>
                        </div>
                    </div>
                </div>
                <small class="text-danger "><b id="errException"></b></small>
                <div class="modal-footer justify-content-center">
                    <a href="" class="btn btn-width btn-secondary btn-flat">CANCELAR</a>
                    <button type="button" class="btn btn-width btn-success btn-flat" onclick="registerUser()" id="btnRegister">REGISTRAR DATOS</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function() {
        listUsers();
        getAccessCRUD();
    });
    function getAccessCRUD(){
        $.ajax({
            url: "<?php echo BASE_URL;?>user/getAccessCRUD",
            type: "POST",
            success: function(response) {
                var jsonData = JSON.parse(response);
                /* console.log(jsonData); */
                if(jsonData.access && jsonData.access.r==0){
                    $(".recent-orders table").css("display","none");
                }
                if(jsonData.access && jsonData.access.c==0){
                    $(".recent-orders .title-table .n-registro").css("display","none");
                }
                if(jsonData.access && jsonData.access.u==0){
                    $(".recent-orders table td .btn-edit").css("display","none");
                }
                if(jsonData.access && jsonData.access.d==0){
                    $(".recent-orders table td .btn-delete").css("display","none");
                }
                if(jsonData.access && jsonData.access.u==0 && jsonData.access.d==0){
                    $(".recent-orders table tr th").last().css("display","none");
                }
            }
        })
    }
    function listUsers() {
        $.ajax({
            url: "<?php echo BASE_URL ?>user/showUsers",
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
                    $.each(data.users, function(idx, val) {
                        cont++;
                        filas +=
                            "<tr>" +
                            "<td>" +
                            cont +
                            "</td>" +
                            "<td class='center-cell'> <div class='profile-photo text-center'><img src='public/users/" + val.avatar + "' width='50' height='50' class='img-fluid'></div></td>" +
                            "<td>" +
                            val.name +
                            " " +
                            val.lastName +
                            "</td>" +
                            "<td>" +
                            val.dni +
                            "</td>" +
                            "<td>" +
                            val.email +
                            "</td>" +
                            "<td>" +
                            val.number +
                            "</td>" +
                            "<td>\
            <button type='button' class='option-buttons btn-edit' data-toggle='modal' data-target='#modal-user' data-backdrop='static' data-keyboard='false' onclick='viewUser(" + val.id + ")'><i class='fa-solid fa-pen'></i></button>\
            <button type='button' class='option-buttons btn-delete' onclick='deleteUser(" + val.id + ")'><i class='fa-solid fa-trash'></i></button>" +
                            "</tr>";
                    });

                    $("#usersTable").html(filas);
                }
            },
        });
    }

    function getSelectedGender() {
        var genderMale = document.getElementById("genderMale");
        var genderFemale = document.getElementById("genderFemale");

        if (genderMale.checked) {
            return "Masculino";
        } else if (genderFemale.checked) {
            return "Femenino";
        } else {
            return ""; // If none of the radio buttons are selected
        }
    }

    function registerUser() {
        var gender = getSelectedGender();
        var formData = new FormData(document.getElementById('formUser'));
        formData.append(
            "gender",
            gender
        );
        $.ajax({
            url: "<?php echo BASE_URL; ?>user/register",
            type: "POST",
            data: formData,
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var data = JSON.parse(response);
                /* Authorized - Server */
                if (data.statusCode == 200) {
                    $("#modal-user").modal('hide');
                    Swal.fire({
                        width: 450,
                        timer: 6000,
                        timerProgressBar: true,
                        title: "Confirmación",
                        text: "Usuario registrado correctamente",
                        icon: "success",
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {

                        window.location.href = '<?php echo BASE_URL ?>user';

                    });
                } /* Not authorized - Server*/
                else if (data.statusCode == 405) {
                    $("#modal-user").modal('hide');
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
                    $("#modal-user").modal('show');

                    $("#errTxtName").text(data.errors.name ? data.errors.name : "");
                    $("#errTxtLastName").text(data.errors.lastName ? data.errors.lastName : "");
                    $("#errTxtDni").text(data.errors.dni ? data.errors.dni : "");
                    $("#errTxtMail").text(data.errors.mail ? data.errors.mail : "");
                    $("#errTxtPhone").text(data.errors.phone ? data.errors.phone : "");
                    $("#errRbGender").text(data.errors.gender ? data.errors.gender : "");
                    $("#errDateBorn").text(data.errors.bornDate ? data.errors.bornDate : "");
                    $("#errCboRole").text(data.errors.role ? data.errors.role : "");
                    $("#errException").text(data.errors.exception ? data.errors.exception : "");
                    $("#errFile").text(data.errors.image ? data.errors.image : "");
                }

            }
        });
    }

    function viewUser(id) {
        $("#title").text("Actualizar Registro");
        $.ajax({
            url: "<?php echo BASE_URL ?>user/showUser/" + id,
            type: "POST",
            success: function(response) {

                var data = JSON.parse(response);

                $("#txtName").val(data.user.name);
                $("#txtLastName").val(data.user.lastName);
                $("#txtDni").val(data.user.dni);
                $("#txtMail").val(data.user.email);
                $("#txtPhone").val(data.user.number);
                $("#dateBorn").val(data.user.bornDate);
                $("#customFile").text(data.user.avatar);
                $("#txtImg").val(data.user.avatar);
                $("#cboRole option[value='" + data.user.idRole + "']").attr("selected", true);
                if (data.user.gender == "Masculino")
                    $("#genderMale").attr("checked", true);
                else
                    $("#genderFemale").attr("checked", true);


                $("#btnRegister").text("Actualizar Datos");
                $("#btnRegister").attr("onclick", "updateUser(" + id + ")");
                $("#modal-user").modal('show');
            }
        });
    }

    function updateUser(id) {
        var gender = getSelectedGender();
        var formData = new FormData(document.getElementById('formUser'));
        formData.append(
            "gender",
            gender
        );
        $.ajax({
            url: "<?php echo BASE_URL; ?>user/update/" + id,
            type: "POST",
            data: formData,
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.statusCode == 200) {
                    $("#modal-user").modal('hide');
                    listUsers();
                    Swal.fire({
                        width: 450,
                        timer: 6000,
                        timerProgressBar: true,
                        title: "Confirmación",
                        text: "Datos actualizados correctamente",
                        icon: "success",
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {

                        window.location.href = '<?php echo BASE_URL ?>user';

                    });
                } /* Not authorized - Server*/
                else if (data.statusCode == 405) {
                    $("#modal-user").modal('hide');
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
                else if (data.statusCode == 500) {
                    $("#modal-user").modal('show');

                    $("#errTxtName").text(data.errors.name ? data.errors.name : "");
                    $("#errTxtLastName").text(data.errors.lastName ? data.errors.lastName : "");
                    $("#errTxtDni").text(data.errors.dni ? data.errors.dni : "");
                    $("#errTxtMail").text(data.errors.mail ? data.errors.mail : "");
                    $("#errTxtPhone").text(data.errors.phone ? data.errors.phone : "");
                    $("#errRbGender").text(data.errors.gender ? data.errors.gender : "");
                    $("#errDateBorn").text(data.errors.bornDate ? data.errors.bornDate : "");
                    $("#errCboRole").text(data.errors.role ? data.errors.role : "");
                    $("#errException").text(data.errors.exception ? data.errors.exception : "");
                    $("#errFile").text(data.errors.image ? data.errors.image : "");
                }
            }
        });
    }

    function deleteUser(id) {

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
                    url: '<?php echo BASE_URL ?>user/delete/' + id,
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
                            listUsers();
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
</script>