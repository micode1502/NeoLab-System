<!-- <div class="date">
    <input type="date">
</div> -->
<div class="recent-orders">
    <div class="title-table d-flex justify-content-between mb-3">
        <h2><?php echo $data["title"]; ?></h2>
        <button type="button" class="btn btn-outline-success n-registro" data-bs-toggle="modal" data-bs-target="#modal-modules" data-bs-backdrop="static" data-bs-keyboard="false">
            <i class="fa-solid fa-plus"></i> NUEVO REGISTRO
        </button>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripcion</th>
                <th>Url</th>
                <th>Icon font</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tblModules">
        </tbody>
    </table>

</div>

<div class="modal fade" id="modal-modules" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <h4 class="modal-title" id="title">Nuevo Registro</h4>
                    <hr>
                </div>
            </div>
            <form id="formModules" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Tipo opción:</label>
                        <div class="col-sm-7">
                            <select name="cboOption" id="cboOption" class="form-control" onchange="showControls()">
                                <option value="1">Módulo</option>
                                <option value="2">Submódulo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="divIcon">
                        <label for="exampleInputEmail1" class="col-sm-4 col-form-label text-right">Icon Font:</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="txtIcon" name="txtIcon">
                            <small class="text-danger "><b id="errtxtIcon"></b></small>
                        </div>
                    </div>
                    <div class="form-group row d-none" id="divCCategory">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Módulo:</label>
                        <div class="col-sm-7">
                            <select name="cboModule" id="cboModule" class="form-control">
                                <?php foreach ($data["modules"] as $row) : ?>
                                    <option value="<?php echo $row["idModule"] ?>"> <?php echo $row["description"] ?> </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger "><b id="errcboCategory"></b></small>
                        </div>
                    </div>
                    <div class="form-group row d-none" id="divSubCat">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Url:</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtUrl" id="txtUrl" class="form-control">
                            <small class="text-danger "><b id="errtxtUrl"></b></small>
                        </div>
                    </div>
                    <div class="form-group row" id="divDescription">
                        <label for="colFormLabel" class="col-sm-4 col-form-label text-right">Descripción:</label>
                        <div class="col-sm-7">
                            <input type="text" name="txtDescription" id="txtDescription" class="form-control">
                            <small class="text-danger "><b id="errtxtDescription"></b></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="" class="btn btn-width btn-secondary btn-flat" onclick="cleanControls()">CANCELAR</a>
                    <button type="button" class="btn btn-width btn-success btn-flat" id="btnRegister" onclick="registerDates(),cleancontrols()">REGISTRAR MODULO</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function() {
        listModules();
        getAccessCRUD();
    })
    function getAccessCRUD(){
        $.ajax({
            url: "<?php echo BASE_URL;?>modules/getAccessCRUD",
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
    function cleanControls() {
        listModules();
        $("#formModulos").trigger('reset');
        $("#errTxtIcon").text("");
        $("#errTxtDescription").text("");
        $("#errTxtUrl").text("");
        $("#title").text("Nuevo Registro");
        $("#btnRegistrar").text("REGISTRAR MODULO");
        $("#btnRegistrar").attr("onclick", "registerDates()");
    }

    function showControls() {
        valor = $("#cboOption").val();
        if (valor == 1) {
            $("#divCategory").removeClass("d-none");
            $("#divIcon").removeClass("d-none");
            $("#divCCategory").addClass("d-none");
            $("#divSubCat").addClass("d-none");
        } else if (valor == 2) {
            $("#divCategory").addClass("d-none");
            $("#divIcon").addClass("d-none");
            $("#divCCategory").removeClass("d-none");
            $("#divSubCat").removeClass("d-none");
            $("#errtxtDescription").text("");
        }
    }

    function listModules() {
        $.ajax({
            url: "<?php echo BASE_URL; ?>modules/viewModules",
            type: 'POST',
            success: function(response) {
                var jsonData = JSON.parse(response);
                /* Not authorized - Server*/
                if (jsonData.statusCode == 405) {
                    /* $("#modal-perfiles").modal('hide'); */
                    if (jsonData.errors.notAuthorized) {
                        Swal.fire({
                            width: 450,
                            timer: 6000,
                            timerProgressBar: true,
                            icon: 'error',
                            title: 'Oops...',
                            text: jsonData.errors.notAuthorized,
                        }).then((result) => {
                            window.location.href = "<?php echo BASE_URL; ?>profile";
                        });
                    }
                } /* Authorized - Server*/
                else {
                    let cont = 0;
                    let rows = "";
                    $.each(jsonData.modules, function(idx, value) {
                        cont++;
                        // ${} en javascript es para mostrar las variables o expresiones de cadenas; se uso operador ternario.
                        // === igualdad estricta
                        rows += `
                                <tr${value.submodule === null ? ` style='font-weight:bold;'` : ''}>
                                <td>${cont}</td>
                                <td${value.submodule === null ? '' : ` style='padding-left:25px;'`}>${value.description}</td>
                                ${value.submodule === null ? "<td>" : `<td>${value.url}</td>`}
                                <td>${value.icon || ''}</td>
                                <td>
                                    <button type='button' class='option-buttons btn-edit' data-bs-toggle='modal' data-bs-target='#modal-modules' data-bs-backdrop='static' data-bs-keyboard='false' onclick='viewModuleId(${value.idModule})'>
                                    <i class='fa fa-pencil-alt'></i>
                                    <span class='sr-only'>Edit</span>
                                    </button>
                                    <button type='button' class='option-buttons btn-delete' onclick='deleteModule(${value.idModule})'>
                                    <i class='far fa-trash-alt'></i>
                                    <span class='sr-only'>Delete</span>
                                    </button>
                                </td>
                                </tr>
                                `;
                    });

                    $("#tblModules").html(rows);
                }

            }
        });
    }


    function registerDates() {
        $.ajax({
            url: "<?php echo BASE_URL; ?>modules/registerModules",
            type: "POST",
            data: new FormData(document.getElementById('formModules')),
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var jsonData = JSON.parse(response);
                /* Authorized - Server */
                if (jsonData.statusCode == 200) {
                    $("#modal-modules").modal('hide');
                    listModules();
                    Swal.fire({
                        width: 450,
                        timer: 6000,
                        timerProgressBar: true,
                        title: "Confirmación",
                        text: "Datos registrados correctamente",
                        icon: "success",
                        confirmButtonText: 'Aceptar'
                    });
                } /* Not authorized - Server*/
                else if (jsonData.statusCode == 405) {
                    $("#modal-modules").modal('hide');
                    if (jsonData.errors.notAuthorized) {
                        Swal.fire({
                            width: 450,
                            timer: 6000,
                            timerProgressBar: true,
                            icon: 'error',
                            title: 'Oops...',
                            text: jsonData.errors.notAuthorized,
                        });
                    }
                } else if (jsonData.statusCode == 500) {
                    //Operador Ternario
                    $("#modal-modules").modal('show');
                    $("#errtxtIcon").text(jsonData.errors.icon ? jsonData.errors.icon : "");
                    $("#errtxtDescription").text(jsonData.errors.description ? jsonData.errors.description : "");
                    $("#errtxtUrl").text(jsonData.errors.url ? jsonData.errors.url : "");
                }

            }
        });
    }

    function viewModuleId(id) {
        $("#title").text("Actualizar Registro");
        $('#cboOption').removeAttr('onchange');
        $.ajax({
            url: "<?php echo BASE_URL ?>modules/viewModuleID/" + id,
            type: "POST",
            success: function(response) {
                var jsonData = JSON.parse(response);
                //Operador Ternario || ToggleClass me permite cambiar a d-none si submodule es igual a null o no
                $("#divCategory").toggleClass('d-none', jsonData.data.submodule == null);
                $("#divSubCat").toggleClass("d-none", jsonData.data.submodule == null);
                $("#divIcon").toggleClass("d-none", jsonData.data.submodule != null);
                $("#cboOption option[value=2]").attr('selected', jsonData.data.submodule != null);
                $("#cboModule option[value='" + jsonData.data.submodule + "']").attr('selected', jsonData.data.submodule == null);

                $("#txtIcon").val(jsonData.data.icon);
                $("#txtUrl").val(jsonData.data.url);
                $("#txtDescription").val(jsonData.data.description);
                $("#btnRegister").text("Actualizar Datos");
                $("#btnRegister").attr("onclick", "updateDates('" + jsonData.data.idModule + "')");
            }
        });
    }

    function updateDates(id) {
        $.ajax({
            url: "<?php echo BASE_URL; ?>modules/updateModules/" + id,
            type: "POST",
            data: new FormData(document.getElementById('formModules')),
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var jsonData = JSON.parse(response);
                if (jsonData.statusCode == 200) {
                    $("#modal-modules").modal('hide');
                    listModules();
                    Swal.fire({
                        width: 450,
                        timer: 6000,
                        timerProgressBar: true,
                        title: "Confirmación",
                        text: "Datos actualizados correctamente",
                        icon: "success",
                        confirmButtonText: 'Aceptar'
                    });
                } /* Not authorized - Server*/
                else if (jsonData.statusCode == 405) {
                    $("#modal-perfiles").modal('hide');
                    if (jsonData.errors.notAuthorized) {
                        Swal.fire({
                            width: 450,
                            timer: 6000,
                            timerProgressBar: true,
                            icon: 'error',
                            title: 'Oops...',
                            text: jsonData.errors.notAuthorized,
                        });
                    }
                } /* Authorized - Server*/
                else if (jsonData.statusCode == 500) {
                    $("#modal-modules").modal('show');
                    //Operador Ternario
                    $("#errtxtIcon").text(jsonData.errors.icon ? jsonData.errors.icon : "");
                    $("#errtxtDescription").text(jsonData.errors.description ? jsonData.errors.description : "");
                    $("#errtxtUrl").text(jsonData.errors.url ? jsonData.errors.url : "");
                }

            }
        });
    }

    function deleteModule(id) {
        Swal.fire({
            width: 450,
            title: 'Confirmación',
            text: "¿Estás segurdo de eliminar el registro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo BASE_URL ?>modules/delete/' + id,
                    type: 'post',
                    success: function(response) {
                        var jsonData = JSON.parse(response);
                        /* Not authorized - Server*/
                        if (jsonData.statusCode == 405) {
                            $("#modal-perfiles").modal('hide');
                            if (jsonData.errors.notAuthorized) {
                                /* $("#errorFile").text(jsonData.errors.notAuthorized); */
                                Swal.fire({
                                    width: 450,
                                    timer: 6000,
                                    timerProgressBar: true,
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: jsonData.errors.notAuthorized,
                                });
                            }
                        } /* Authorized - Server*/
                        else {
                            listModules();
                            Swal.fire({
                                width: 450,
                                timer: 6000,
                                timerProgressBar: true,
                                title: "Confirmación",
                                text: jsonData.mensaje,
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