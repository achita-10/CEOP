<template>
    <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <div class="container-fluid">
                <div>
                    <a-card
                        style="width:100%"
                        title="Grupos"
                        >
                        <a slot="extra" href="#" @click="mostrar_Modal('grupo','registrar')">Registrar</a>
                        <el-table
                            :data="arrayGrupos.filter(data => !search || data.Nombre.toLowerCase().includes(search.toLowerCase()) || data.Encargado.toLowerCase().includes(search.toLowerCase()) )"
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
                            label="Encargado"
                            prop="Encargado">
                            </el-table-column>
                            <el-table-column
                            label="Fecha"
                            prop="Fecha">
                            </el-table-column>
                            <el-table-column
                            align="right">
                            <template slot="header" slot-scope="scope">
                                <el-input
                                v-model="search"
                                size="mini"
                                placeholder="Buscar"/>
                            </template>
                            <template slot-scope="scope">
                                <el-button
                                size="medium"
                                @click="mostrar_Modal('grupo','actualizar',scope.row)" type="primary" circle><i class="el-icon-edit"></i></el-button>
                            </template>
                            </el-table-column>
                        </el-table> 
                    </a-card>
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
                                        <el-input suffix-icon="el-icon-document" size="medium" v-model="ruleForm.Encargado"></el-input>
                                    </el-form-item>
                                </a-col>
                            </a-row>
                        </el-form>
                    </a-modal>                   
                </div>
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
                //tabla
                search:'',
                //variables
                arrayGrupos:[],
                ID_Grupo:0,
                tituloModal:'',
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
                        { required: false, message: 'Puede o no ingresar este campo', trigger: 'change' },
                        { min: 4, message: 'La longitud debe ser mayor a 4 caracteres', trigger: 'blur' }
                    ],
                },
            }
        },
        
        methods:{
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
            },
            mostrar_Modal(modelo,accion,data=[]){
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
                                this.ruleForm.Nombre         =   data['Nombre'];
                                this.ruleForm.Encargado=   data['Encargado'];
                                break;
                            }
                        }
                    }
                }   
            },
        },
        mounted() {
            this.listarGrupos();
        }
    }
</script>
