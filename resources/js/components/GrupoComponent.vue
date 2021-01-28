<template>
    <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <div class="container-fluid">
              <el-card class="box-card" >
                <div slot="header" class="clearfix">
                    <!-- <span >{{encabezado}} </span><span v-if="Vista==1">miembros: {{total}}</span> -->
                    <template v-if="Vista==1">
                        <el-link  @click="pdfAsistencia('ruleFormAsistencia')" type="danger">Reporte Asistencia</el-link>
                        <el-link  @click="pdfIntegrantes()" type="danger">Reporte Integrantes</el-link>
                    </template>
                    <template v-if="Vista==0">
                        <span >{{encabezado}} </span>
                        <el-link  @click="pdf()" type="danger">PDF</el-link>
                        <vue-excel-xlsx
                            :data="arrayGrupos"
                            :columns="columns"
                            :filename="'Grupos_'+Fecha"
                            :sheetname="'Grupos'"
                            class="btn btn-default"
                            >
                            Excel
                        </vue-excel-xlsx>
                    </template>
                    <el-button v-if="Vista==0" style="float: right; padding: 3px 0"  @click="mostrar_Modal('grupo','registrar')" type="text">Registrar</el-button>
                    <el-button v-if="Vista==1" style="float: right; padding: 3px 0"  @click="regresar()" type="text">Regresar</el-button>
                </div>
                  <template v-if="Vista==0">
                    <el-table
                      :data="arrayGrupos.filter(data => !search ||  data.Grupo.toLowerCase().includes(search.toLowerCase()) || data.Encargado.toLowerCase().includes(search.toLowerCase())  )"
                      style="width: 100%; " max-height="400"
                      >
                      <el-table-column
                      label="id"
                      prop="id">
                      </el-table-column>
                      <el-table-column
                      label="Nombre"
                      prop="Grupo">
                      </el-table-column>
                      <el-table-column
                      label="Encargado"
                      prop="Encargado">
                      
                      </el-table-column>
                      <el-table-column
                        label="Apellido Paterno"
                        prop="Apellido_P">
                        </el-table-column>
                        <el-table-column
                        label="Apellido Materno"
                        prop="Apellido_M">
                        </el-table-column>
                      <el-table-column
                      align="right">
                      <template :slot="buscar" slot-scope="scope">
                          <el-input
                          v-model="search"
                          size="mini"
                          placeholder="Buscar"/>
                      </template>
                      <template slot-scope="scope">
                        <section style="text-align:center;">
                            <el-button
                            title="Eliminar Grupo"
                            size="small"
                            @click="eliminarGrupo(scope.row)" type="danger" circle>
                                <i class="el-icon-circle-close"></i>
                            </el-button>
                            <el-button
                            title="Ver información"
                            size="small"
                            @click="verInformacion(scope.row.id,scope.row.Grupo)" type="success" circle>
                                <i class="el-icon-view"></i>
                            </el-button>
                            <el-button
                            title="Actualizar grupo"
                            size="small"
                            @click="mostrar_Modal('grupo','actualizar',scope.row)" type="primary" circle>
                                <i class="el-icon-edit"></i>
                            </el-button>
                        </section>
                      </template>
                      </el-table-column>
                    </el-table>
                  </template>
                  <template v-else>
                    <el-form size="mini" label-position="left" status-icon :model="ruleFormAsistencia" :rules="rulesAsistencia" ref="ruleFormAsistencia" label-width="80px" class="demo-ruleForm">
                        <a-row :gutter="16">
                            <a-col :xs="24" :sm="12" :md="8">
                                <el-form-item label="Trimestre" prop="Trimestre">
                                    <el-select  placeholder="Seleccione" v-model="ruleFormAsistencia.Trimestre">
                                        <el-option  value="">Seleccione</el-option>
                                        <el-option label="Trimestre 1" value="1"> </el-option>
                                        <el-option label="Trimestre 2" value="2"> </el-option>
                                        <el-option label="Trimestre 3" value="3"> </el-option>
                                        <el-option label="Trimestre 4" value="4"> </el-option>
                                    </el-select>
                                </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8">
                                <el-form-item label="Año" prop="Fecha">
                                    <el-date-picker
                                        v-model="ruleFormAsistencia.Fecha"
                                        type="year"
                                        value-format="yyyy"
                                        placeholder="Seleccione año">
                                    </el-date-picker>
                                </el-form-item>
                            </a-col>
                        </a-row>
                    </el-form>
                    <el-table
                    :data="arrayMiembros.filter(data => !search ||  data.Nombre.toLowerCase().includes(search.toLowerCase()) || data.Apellido_P.toLowerCase().includes(search.toLowerCase()) || data.Apellido_M.toLowerCase().includes(search.toLowerCase()) )"
                    style="width: 100%; " max-height="400">
                    <el-table-column
                    label="id"
                    prop="id">
                    </el-table-column>
                    <el-table-column
                    label="Nombre"
                    prop="Nombre">
                    </el-table-column>
                    <el-table-column
                    label="Apellido Paterno"
                    prop="Apellido_P">
                    </el-table-column>
                    <el-table-column
                    label="Apellido Materno"
                    prop="Apellido_M">
                    </el-table-column>
                    
                    <el-table-column
                    align="right">
                    <template :slot="buscar" slot-scope="scope">
                        <el-input
                        v-model="search"
                        size="mini"
                        placeholder="Buscar"/>
                    </template>
                    <template slot-scope="scope">
                        <section style="text-align:center;">
                            <el-button
                                title="Registrar asistencia"
                                size="small"
                                @click="ingresar(scope.row.id,scope.row.Condicion)" type="success" circle>
                                <i class="el-icon-circle-plus"></i>
                            </el-button>
                        </section>
                    </template>
                    </el-table-column>
                  </el-table>
                    <!-- <el-table
                        :data="arrayMiembros.filter(data => !search ||  data.Nombre.toLowerCase().includes(search.toLowerCase()) || data.FechaIngreso.toLowerCase().includes(search.toLowerCase()) || data.Apellido_M.toLowerCase().includes(search.toLowerCase())  || data.Apellido_P.toLowerCase().includes(search.toLowerCase())  )"
                        style="width: 100%"
                        max-height="330">
                        <el-table-column
                        label="id"
                        prop="id">
                        </el-table-column>
                        <el-table-column
                        label="Nombre"
                        prop="Nombre">
                        </el-table-column>
                        <el-table-column
                        label="Apellido Paterno"
                        prop="Apellido_P">
                        </el-table-column>
                        <el-table-column
                        label="Apellido Materno"
                        prop="Apellido_M">
                        </el-table-column>
                        <el-table-column
                        label="Fecha de Ingreso"
                        prop="FechaIngreso">
                        </el-table-column>
                        <el-table-column
                        align="right">
                        <template :slot="buscar" slot-scope="scope">
                            <el-input
                            v-model="search"
                            size="mini"
                            placeholder="Buscar"/>
                        </template>
                        <template slot-scope="scope">
                            
                        </template>
                        </el-table-column>
                    </el-table> -->
                  </template>
              </el-card>
                <a-modal v-model="Modal" :title="tituloModal" on-ok="handleOk">
                    <template slot="footer">
                        <a-button key="back" @click="handleOk" >
                        Regresar
                        </a-button>
                        <el-button key="" type="success"  v-if="Accion==0" @click="submitForm('ruleForm')">
                        Guardar
                        </el-button>
                        <el-button key="" type="success"  v-if="Accion==1" @click="submitForm('ruleForm')">
                        Actualizar
                        </el-button>
                    </template>
                    <el-form :label-position="labelPosition" status-icon :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
                        <a-row :gutter="16">
                            <a-col xs:="24" :sm="24" :md="12">
                                <el-form-item label="Nombre" prop="Nombre">
                                    <el-input suffix-icon="el-icon-info" size="medium" v-model="ruleForm.Nombre"></el-input>
                                </el-form-item>
                            </a-col>
                            <a-col xs:="24" :sm="24" :md="12">
                                <el-form-item label="Encargado" prop="Encargado">
                                    <el-select   v-model="ruleForm.Encargado">
                                    <el-option  value="">Seleccione</el-option>
                                    <el-option
                                        v-for="miembro in arrayMiembros"
                                        :key="miembro.id"
                                        :label="miembro.Nombre"
                                        :value="miembro.id">
                                    </el-option>
                                    
                                    </el-select>
                                </el-form-item>
                            </a-col>
                        </a-row>
                    </el-form>
                </a-modal> 
            </div>
        </div>
        
    </main>
</template>
<!--

Calcular Edad
    Route::get('/get-age',function(){
        $fecha_nacimiento  = "1990-10-23";
        $edad = \Carbon\Carbon::parse($fecha_nacimiento )->age;
        return $edad;

    });
-->
<script>
 import Swal from 'sweetalert2/dist/sweetalert2.js'
    export default {
         data(){
            return{
                Dia:"",
                Lista:[],
                Fecha: '',
                Contar:0,
                buscar:'header',
                Vista:0,
                activos:[],
                //miembros
                arrayMiembros:[],
                //tabla
                search:'',
                
                //variables
                arrayGrupos:[],
                encabezado:'Grupos',
                ID_Grupo:'',
                tituloModal:'',
                total:0,
                //modal
                Modal:false,
                Titulo:'',
                Accion:0,
                labelPosition: 'top',
                //Formulario Asistencia
                arrayVerificarA:[],
                ruleFormAsistencia: {
                    Trimestre: '',
                    Fecha: '',
                },
                rulesAsistencia: {
                    Trimestre: [
                        {  required: true, message: 'Requerido', trigger: 'change' }
                    ],
                    Fecha: [
                        {  required: true, message: 'Requerido', trigger: 'change' }
                    ],
                },
                //formulario
                ruleForm: {
                    Nombre: '',
                    Encargado: '',
                },
                rules: {
                    Nombre: [
                        { required: true, message: 'Por favor ingrese un nombre', trigger: 'change' },
                        { min: 4, message: 'La longitud debe ser mayor 3 caracteres', trigger: 'blur' },
                    ],
                    Encargado: [
                        { required: true, message: 'Por favor seleccione al encargado', trigger: 'change' },
                        
                    ],
                },
                columns:[
                    {
                        label: "#",
                        field: "id",
                        dataFormat: this.contador
                    },
                    {
                        label: "Grupo",
                        field: "Grupo",
                    },
                    {
                        label: "Encargado",
                        field: "Encargado",
                    },
                    {
                        label: "Apellido Paterno",
                        field: "Apellido_P",
                    },
                    {
                        label: "Apellido Materno",
                        field: "Apellido_M",
                    }
                ],
            }
        },
        
        methods:{
            pdfIntegrantes(){
                if(this.arrayMiembros<=0){
                    Swal.fire('No existen registros de busqueda','','info');
                }else{
                    window.open('/ministerio/pdf/integrantes?Ministerio='+this.ID_Grupo+"&Tipo=2");
                }
            },
            ingresar(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: '¿Desea registrar la asistencia?',
                text: "Presione Aceptar o Cancelar para regresar",
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    // let dias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];
                    // let date = new Date(me.Fecha.replace(/-+/g, '/'));
                    // var fechaNum = date.getDate();
                    // var mes_name = date.getMonth();
                    // Swal.fire(dias[date.getDay()-1]);
                    var fecha = new Date();
                    me.Dia=fecha.getDay();
                    axios.post('/asistencia/verificar',{
                        'ID':id
                    }).then(function (response) {
                        var respuesta = response.data;
                        me.Lista=respuesta.lista;
                        if(me.Lista.length>0){
                            Swal.fire("Ya se registro la asistencia para este miembro",'','info');
                        }else{
                            if(me.Dia!=0){
                                Swal.fire("Solo se permite pasar asistencia Domingo",'','info');
                            }else{
                                axios.post('/asistencia/guardar',{
                                    'ID':id
                                }).then(function (response) {
                                    Swal.fire('Asistencia registrada','','success');
                                })
                                .catch(function (error) {
                                    // handle error
                                    Swal.fire('No se verifico el dia','','error');
                                })
                                .finally(function () {
                                    // always executed
                                });
                            }
                        }
                    })
                    .catch(function (error) {
                        // handle error
                        Swal.fire('Ocurrio un error','','error');
                    })
                    .finally(function () {
                        // always executed
                    });
                    
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            contador(value){
                var longitud = this.arrayGrupos.length;
                // this.Contar++;
                if(longitud<=this.Contar){
                    this.Contar=0;
                    this.Contar++;
                }else{
                    this.Contar++;
                }
                    return this.Contar;
            },
            pdfAsistencia(formName){
                
                this.$refs[formName].validate(valid => {
                    if (valid) {
                        let me = this;
                        var url = '/grupo/verificarAsistencia?Trimestre='+me.ruleFormAsistencia.Trimestre+"&Fecha="+me.ruleFormAsistencia.Fecha+"&Grupo="+me.ID_Grupo;
                        axios.get(url).then(function (response) {
                            // handle success
                            var respuesta = response.data;
                            me.arrayVerificarA=respuesta.asistencias;
                            if(me.arrayVerificarA.length>0){
                                window.open('/grupo/pdf/asistencia?Trimestre='+me.ruleFormAsistencia.Trimestre+"&Fecha="+me.ruleFormAsistencia.Fecha+"&Grupo="+me.ID_Grupo);
                            }else{
                                Swal.fire("No existen asistencias en ese trimestre",'','info');
                            }
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .finally(function () {
                            // always executed
                        });
                         
                    }else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            pdf(){
                if(this.arrayGrupos<=0){
                    Swal.fire('No existen registros de busqueda','','info');
                }else{
                    window.open('/grupo/pdf');
                }
            },
            regresar(){
                let me = this;
                me.Vista=0;
                me.arrayGrupos=[];
                me.listarGrupos();
                me.buscar='header';
                me.encabezado='Grupos';
                
            },
            verInformacion(id,nombre){
                let me =this;
                me.Vista=1;
                me.ID_Grupo=id;
                me.arrayMiembros=[];
                me.encabezado=nombre;
                me.buscar='header';
                me.listarMiembroGrupo();
                me.limpiarCampos();
            },
            eliminarGrupo(data=[]){
                let me=this;
                me.activos=[];
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: '¿Desea eliminar el grupo '+data['Grupo']+'?',
                text: "Presione Aceptar o Cancelar para regresar",
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    
                    axios.post('/miembro/activoDepartamento',{
                        'Departamento':data['id'],
                        'Tipo': 1
                    }).then(function (response) {
                        var respuesta = response.data;
                        me.activos = respuesta.miembros;
                        if (me.activos.length>0){
                            let timerInterval
                            Swal.fire({
                            title: 'El grupo tiene miembros activos, ¿Desea eliminarlo?',
                            timer: 10000,
                            timerProgressBar: true,
                            willOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                if (content) {
                                    const b = content.querySelector('b')
                                    if (b) {
                                    b.textContent = Swal.getTimerLeft()
                                    }
                                }
                                }, 100)
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.value) {
                                me.eliminar(data['id']);
                            }
                            })
                        }else{
                            me.eliminar(data['id']);
                        }
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .finally(function () {
                        // always executed
                    });
                    
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            eliminar(id){
                let me=this;
                    //Las variables Nombre y Descripcion son las definidas en la funcion data
                axios.put('/grupo/eliminar',{
                    'id': id,
                }).then(function (response) {
                    Swal.fire('Grupo eliminado','','success');
                    me.handleOk();
                    me.listarGrupos();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    Swal.fire('Ocurrio un error al eliminar el grupo','','error');
                })
                .finally(function () {
                    // always executed
                });
            },
            listarMiembroGrupo(){
                let me=this;
                var url = '/miembro/activoCampo?Tipo=1&Nombre='+me.ID_Grupo;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayMiembros=respuesta.miembros;
                    me.total=me.arrayMiembros.length;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            listarMiembros(){
                let me=this;
                var url = '/miembro/activo';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayMiembros=respuesta.activos;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            //modal
            showModal() {
                this.Modal = true;
            },
            handleOk() {
                this.Modal = false;
            },
            //funcionalidades, registrar, actualizar etc..
            listarGrupos(){
                let me=this;
                var url = '/grupo';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayGrupos=respuesta.grupos;
                    
                    
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
             //formulario
            submitForm(formName) {
                this.$refs[formName].validate(valid => {
                    if (valid) {
                        if(this.Accion==0){
                            this.Titulo='¿Desea registrar el grupo?';
                        }else{
                            this.Titulo='¿Desea actualizar el grupo';
                        }
                        const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                        })

                        swalWithBootstrapButtons.fire({
                        title: this.Titulo,
                        text: "Presione Aceptar o Cancelar para regresar",
                        icon: 'question',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Aceptar',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.value) {
                            let me=this;
                            if(me.Accion==0){
                                me.registrarGrupo();
                            }else{
                                me.actualizarGrupo();
                            }
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            
                        }
                        })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            registrarGrupo(){
                let me=this;
                axios.post('/grupo/registrar',{
                    'Nombre':this.ruleForm.Nombre,
                    'Encargado':this.ruleForm.Encargado,
                }).then(function (response) {
                    Swal.fire('Grupo registrado','','success');
                    me.handleOk();
                    me.listarGrupos();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            actualizarGrupo(formName){
                let me=this;
                    //Las variables Nombre y Descripcion son las definidas en la funcion data
                axios.put('/grupo/actualizar',{
                    'ID': this.ID_Grupo,
                    'Nombre':this.ruleForm.Nombre,
                    'Encargado':this.ruleForm.Encargado,
                }).then(function (response) {
                    Swal.fire('Grupo actualizado','','success');
                    me.handleOk();
                    me.listarGrupos();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            limpiarCampos(){
                this.ruleForm.Nombre="";
                this.ruleForm.Encargado="";
                this.ruleFormAsistencia.Trimestre='';
                this.ruleFormAsistencia.Fecha='';
            },
            mostrar_Modal(modelo,accion,data=[]){
                this.listarMiembros();
                switch(modelo){
                    case 'grupo':{
                        switch(accion){
                            case 'registrar':{
                                if(this.$refs.ruleForm){
                                    this.resetForm('ruleForm'); 
                                }
                                this.Modal = true;
                                this.tituloModal    =   'Registrar grupo';
                                this.Accion=0;
                                this.limpiarCampos();
                                break;
                            }
                            case 'actualizar':{
                                this.Modal = true;
                                this.Accion=1;
                                this.tituloModal    =   'Actualizar grupo';
                                this.ID_Grupo     =   data['id'];
                                this.ruleForm.Nombre         =   data['Grupo'];
                                this.ruleForm.Encargado=  parseInt(  data['ID_E']);
                                break;
                            }
                        }
                    }
                }   
            },
            CalcularFecha(){
                var d= new Date();
                var month = d.getMonth()+1;
                var day = d.getDate();

                var output = d.getFullYear() + '/' +
                    (month<10 ? '0' : '') + month + '/' +
                    (day<10 ? '0' : '') + day;
                this.Fecha= output;
            },
        },
        mounted() {
            this.listarGrupos();
            this.CalcularFecha();
        }
    }
</script>
