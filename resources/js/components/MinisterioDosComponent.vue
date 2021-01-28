<template>
    <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <div class="container-fluid">
              <el-card class="box-card" >
                <div slot="header" class="clearfix">
                    <!-- <span >{{encabezado}} </span><span v-if="Vista==1">miembros: {{total}}</span> -->
                    <template v-if="Vista==1">
                        <el-link  @click="pdfIntegrantes()" type="danger">Reporte Integrantes</el-link>
                    </template>
                    <template v-else>
                        <span >{{encabezado}} </span>
                        <el-link v-if="Vista==0" @click="pdf()" type="danger">PDF</el-link>
                        <vue-excel-xlsx
                            :data="arrayMinisterios"
                            :columns="columns"
                            :filename="'Ministerios_'+Fecha"
                            :sheetname="'Ministerios'"
                            class="btn btn-default"
                            >
                            Excel
                        </vue-excel-xlsx>
                    </template>
                    <el-button v-if="Vista==0" style="float: right; padding: 3px 0"  @click="mostrar_Modal('ministerio','registrar')" type="text">Registrar</el-button>
                    <el-button v-if="Vista==1" style="float: right; padding: 3px 0"  @click="regresar()" type="text">Regresar</el-button>
                </div>
                  <template v-if="Vista==0">
                    <el-table
                      :data="arrayMinisterios.filter(data => !search ||  data.Ministerio.toLowerCase().includes(search.toLowerCase()) || data.Encargado.toLowerCase().includes(search.toLowerCase())  )"
                      style="width: 100%; " max-height="400"
                      >
                      <el-table-column
                      label="id"
                      prop="id">
                      </el-table-column>
                      <el-table-column
                      label="Nombre"
                      prop="Ministerio">
                      </el-table-column>
                      <el-table-column
                      label="Encargado"
                      prop="Encargado">
                      </el-table-column>
                      <el-table-column
                        prop="Apellido_P"
                        label="A Paterno">
                        </el-table-column>
                        <el-table-column
                        prop="Apellido_M"
                        label="A Materno">
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
                        <!-- <el-button
                        title="Eliminar ministerio"
                        size="small"
                        @click="eliminarMinisterio(scope.row)" type="danger" circle>
                            <i class="el-icon-circle-close"></i>
                        </el-button> -->
                        <el-button
                        title="Ver información"
                        size="small"
                        @click="verInformacion(scope.row.id,scope.row.Ministerio)" type="success" circle>
                            <i class="el-icon-view"></i>
                        </el-button>
                        <!-- <el-button
                        title="Actualizar ministerio"
                        size="small"
                        @click="mostrar_Modal('ministerio','actualizar',scope.row)" type="primary" circle>
                            <i class="el-icon-edit"></i>
                        </el-button> -->
                      </template>
                      </el-table-column>
                    </el-table>
                  </template>
                  <template v-else>
                    <el-table
                        :data="arrayMiembros.filter(data => !search ||  data.Nombre.toLowerCase().includes(search.toLowerCase()) || data.FechaIngreso.toLowerCase().includes(search.toLowerCase()) || data.Apellido_M.toLowerCase().includes(search.toLowerCase())  || data.Apellido_P.toLowerCase().includes(search.toLowerCase())  )"
                        style="width: 100%;" max-height="400">
                        <el-table-column
                        prop="id"
                        label="id">
                        </el-table-column>
                        <el-table-column
                        prop="Nombre"
                        label="Nombre">
                        </el-table-column>
                        <el-table-column
                        prop="Apellido_P"
                        label="A Paterno">
                        </el-table-column>
                        <el-table-column
                        prop="Apellido_M"
                        label="A Materno">
                        </el-table-column>
                        <el-table-column
                        prop="FechaIngreso"
                        label="Fecha de Ingreso">
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
                    </el-table>
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
                Fecha:'',
                Contar:0,
                buscar:'header',
                Vista:0,
                activos:[],
                //miembros
                arrayMiembros:[],
                //tabla
                search:'',
                //variables
                arrayMinisterios:[],
                encabezado:'Ministerios',
                ID_Ministerio:'',
                tituloModal:'',
                total:0,
                //modal
                Modal:false,
                Titulo:'',
                Accion:0,
                labelPosition: 'top',
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
                        label: "Ministerio",
                        field: "Ministerio",
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
                    window.open('/ministerio/pdf/integrantes?Ministerio='+this.ID_Ministerio+"&Tipo=1");
                }
            },
            contador(value){
                var longitud = this.arrayMinisterios.length;
                // this.Contar++;
                if(longitud<=this.Contar){
                    this.Contar=0;
                    this.Contar++;
                }else{
                    this.Contar++;
                }
                    return this.Contar;
            },
            pdf(){
                if(this.arrayMinisterios<=0){
                    Swal.fire('No existen registros de busqueda','','info');
                }else{
                    window.open('/ministerio/pdf');
                }
            },
            regresar(){
                let me = this;
                me.Vista=0;
                me.arrayMinisterios=[];
                me.listarMinisterios();
                me.buscar='header';
                me.encabezado='Ministerios';
                
            },
            verInformacion(id,nombre){
                let me =this;
                me.Vista=1;
                me.ID_Ministerio=id;
                me.arrayMiembros=[];
                me.encabezado=nombre;
                me.buscar='header';
                me.listarMiembroMinisterio();
                
            },
            eliminarMinisterio(data=[]){
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
                title: '¿Desea eliminar el ministerio '+data['Ministerio']+'?',
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
                        'Tipo': 2
                    }).then(function (response) {
                        var respuesta = response.data;
                        me.activos = respuesta.miembros;
                        if (me.activos.length>0){
                            let timerInterval
                            Swal.fire({
                            title: 'El ministerio tiene miembros activos, ¿Desea eliminarlo?',
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
                axios.put('/ministerio/eliminar',{
                    'id': id,
                }).then(function (response) {
                    Swal.fire('Ministerio eliminado','','success');
                    me.handleOk();
                    me.listarMinisterios();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    Swal.fire('Ocurrio un error al eliminar el ministerio','','error');
                })
                .finally(function () {
                    // always executed
                });
            },
            listarMiembroMinisterio(){
                let me=this;
                var url = '/miembro/activoCampo?Tipo=2&Nombre='+me.ID_Ministerio;
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
            listarMinisterios(){
                let me=this;
                var url = '/ministerio';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayMinisterios=respuesta.ministerios;
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
                            this.Titulo='¿Desea registrar el ministerio?';
                        }else{
                            this.Titulo='¿Desea actualizar el ministerio';
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
                                me.registrarMinisterio();
                            }else{
                                me.actualizarMinisterio();
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
            registrarMinisterio(){
                let me=this;
                axios.post('/ministerio/registrar',{
                    'Nombre':this.ruleForm.Nombre,
                    'Encargado':this.ruleForm.Encargado,
                }).then(function (response) {
                    Swal.fire('Ministerio registrado','','success');
                    me.handleOk();
                    me.listarMinisterios();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            actualizarMinisterio(formName){
                let me=this;
                    //Las variables Nombre y Descripcion son las definidas en la funcion data
                axios.put('/ministerio/actualizar',{
                    'ID': this.ID_Ministerio,
                    'Nombre':this.ruleForm.Nombre,
                    'Encargado':this.ruleForm.Encargado,
                }).then(function (response) {
                    Swal.fire('Ministerio actualizado','','success');
                    me.handleOk();
                    me.listarMinisterios();
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
            },
            mostrar_Modal(modelo,accion,data=[]){
                this.listarMiembros();
                switch(modelo){
                    case 'ministerio':{
                        switch(accion){
                            case 'registrar':{
                                if(this.$refs.ruleForm){
                                    this.resetForm('ruleForm'); 
                                }
                                this.Modal = true;
                                this.tituloModal    =   'Registrar ministerio';
                                this.Accion=0;
                                this.limpiarCampos();
                                break;
                            }
                            case 'actualizar':{
                                this.Modal = true;
                                this.Accion=1;
                                this.tituloModal    =   'Actualizar ministerio';
                                this.ID_Ministerio     =   data['id'];
                                this.ruleForm.Nombre         =   data['Ministerio'];
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
            this.listarMinisterios();
            this.CalcularFecha();
        }
    }
</script>
