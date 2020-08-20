<template>
  <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <div class="container-fluid">
              <el-card class="box-card">
                <div slot="header" class="clearfix">
                  <span>Visitantes</span>
                  <el-button style="float: right; padding: 3px 0"  @click="mostrarModal('visitante','registrar')" type="text">Registrar</el-button>
                </div>
                <div  class="text item">
                  <el-table
                    :data="arrayVisitantes.filter(data => !search ||  data.Nombre.toLowerCase().includes(search.toLowerCase()) || data.Apellido_P.toLowerCase().includes(search.toLowerCase()) || data.Apellido_M.toLowerCase().includes(search.toLowerCase()) )"
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
                        @click="mostrarModal('visitante','actualizar',scope.row)" type="primary" circle><i class="el-icon-edit"></i></el-button>
                        
                    </template>
                    </el-table-column>
                  </el-table>
                </div>
              </el-card>
                <a-modal :width="800"  v-model="Modal" :title="tituloModal" on-ok="handleOk">
                  <template slot="footer">
                    <el-button key="back" @click="cerrarModal" >
                      Regresar
                    </el-button>
                    <el-button  type="success"  v-if="Accion==0" @click="submitForm('ruleForm')">
                      Guardar
                    </el-button>
                    <el-button type="success"  v-if="Accion==1" @click="submitForm('ruleForm')">
                      Actualizar
                    </el-button>
                  </template>
                  <el-form size="small" :label-position="labelPosition" status-icon :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
                    <a-row :gutter="16">
                      <el-tabs v-model="Seccion" >
                        <el-tab-pane label="Personales" name="first">
                          <a-col :xs="24" :sm="12" :md="8">
                            <el-form-item label="Nombre" prop="Nombre">
                              <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Nombre"></el-input>
                            </el-form-item>
                          </a-col>
                          <a-col :xs="24" :sm="12" :md="8" >
                            <el-form-item label="Apellido Paterno" prop="Apellido_P">
                              <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Apellido_P"></el-input>
                            </el-form-item>
                          </a-col>
                          <a-col :xs="24" :sm="12" :md="8" >
                            <el-form-item label="Apellido Materno" prop="Apellido_M">
                              <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Apellido_M"></el-input>
                            </el-form-item>
                          </a-col>
                          <a-col :xs="24" :sm="12" :md="8">
                            <el-form-item label="" >
                              <template v-if="AccionImagen==0 || ActualizarImagen==1">
                                  <img-inputer class="img-inputer--large" v-model="file" theme="light" size="large"/>
                              </template>
                              <template v-else>
                                <div class="demo-image__preview">
                                  <el-image 
                                    style="width: 240px; height: 200px"
                                    :src="'img/'+Imagen" 
                                    :preview-src-list="srcList">
                                  </el-image>
                                </div>
                              </template>
                            </el-form-item>
                          </a-col>
                        </el-tab-pane>
                        <el-tab-pane label="Contacto" name="second">
                          <a-col :xs="24" :sm="12" :md="8">
                            <el-form-item label="Correo" prop="Correo">
                              <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Correo"></el-input>
                            </el-form-item>
                          </a-col>
                          <a-col :xs="24" :sm="12" :md="8" >
                            <el-form-item label="Telefono" prop="Telefono">
                              <el-input maxlength="10" show-word-limit  suffix-icon="el-icon-info"  v-model.number="ruleForm.Telefono"></el-input>
                            </el-form-item>
                          </a-col>
                          <a-col :xs="24" :sm="12" :md="8" >
                            <el-form-item label="Congregación" prop="Congregacion">
                              <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Congregacion"></el-input>
                            </el-form-item>
                          </a-col>
                          <a-col :xs="24" :sm="12" :md="8" >
                            <el-form-item label="Red Social" prop="RedSocial">
                              <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.RedSocial"></el-input>
                            </el-form-item>
                          </a-col>
                        </el-tab-pane>
                      </el-tabs>
                      
                    </a-row>
                  </el-form>
                </a-modal>
            </div>
        </div>
        
    </main>
</template>
<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'
import VueEasyLightbox from 'vue-easy-lightbox'
   export default {
    data() {
      var checkTelefono = (rule, value, callback) => {
        if (value) {
          setTimeout(() => {
            if (!Number.isInteger(value)) {
              callback(new Error('Por favor ingrese solo números'));
            } else {
              callback();
              // if (value < 18) {
              //   callback(new Error('Age must be greater than 18'));
              // } else {
              //   callback();
              // }
            }
          }, 1000);
        }else{
          callback();
        }
      };
      return { 
        //tabs
        Seccion:'first',
        //tabla
        search:'',
        //Articulo
        arrayVisitantes:[],
        ID_Visitante:0,
        //modal
        Modal:false,
        tituloModal:'',
        //imagen
        visible:false,
        AccionImagen : 0,
        ActualizarImagen : 0,
        Imagen : '',
        file : null,
        imgs: '',  // Img Url , string or Array
        index: 0,   // default
        srcList: [],
        //Formulario
        labelPosition: 'top',
        Titulo:'',
        Accion:0,
        ruleForm: {
          Nombre: '',
          Apellido_P: '',
          Apellido_M: '',
          Correo:'',
          Telefono:'',
          Congregacion:'',
          RedSocial:'',

        },
        rules: {
          Nombre: [
            { required: true, message: 'Por favor ingrese un nombre', trigger: 'change' },
            { min: 4, message: 'La longitud debe ser mayor 3 caracteres', trigger: 'blur' },
          ],
          Apellido_P: [
            { required: true, message: 'Por favor ingrese un apellido', trigger: 'change' },
            { min: 4, message: 'La longitud debe ser mayor a 3 caracteres', trigger: 'blur' }
          ],
          Apellido_M: [
            { required: true, message: 'Por favor ingrese un apellido', trigger: 'change' },
            { min: 4, message: 'La longitud debe ser mayor a 3 caracteres', trigger: 'blur' }
          ],
          Correo:[
            { required: false, message: 'Puede o no ingresar el correo', trigger: 'blur' },
            { type: 'email', message: 'Por favor ingrese un correo valido', trigger: ['blur', 'change'] }
          ],
          Telefono:[
            {validator: checkTelefono,trigger:'blur'}
          ],
          Congregacion:[
            { required: false, message: 'Puede o no ingresar la ocupación', trigger: 'blur' },
            { min: 4, message: 'La longitud debe ser mayor a 3 caracteres', trigger: 'blur' }
          ],  
          RedSocial:[
            { required: false, message: 'Puede o no ingresar la dirección', trigger: 'blur' },
            { min: 4, message: 'La longitud debe ser mayor a 3 caracteres', trigger: 'blur' }
          ]
        }
      };
    },
    components: {   
      VueEasyLightbox
    },
    methods: {
      //imagen
      showSingle() {
          this.imgs = 'img/' + this.Imagen;
          this.show()
      },
      show() {
          this.visible = true
      },
      handleHide() {
          this.visible = false
      },
      //formulario
      submitForm(formName) {
        this.$refs[formName].validate(valid => {
          if (valid) {
            if(this.Accion==0){
              this.Titulo='¿Desea registrar al visitante?';
            }else{
              this.Titulo='¿Desea actualizar al visitante?';
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
                  me.registrarVisitante();
                }else{
                  me.actualizarVisitante();
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
      registrarVisitante(){
        let me=this;
        //Creamos el formData
        var data = new  FormData();
        data.append('Nombre', this.ruleForm.Nombre);
        data.append('Apellido_P', this.ruleForm.Apellido_P);
        data.append('Apellido_M', this.ruleForm.Apellido_M);
        data.append('Correo', this.ruleForm.Correo);
        data.append('Telefono', this.ruleForm.Telefono);
        data.append('Congregacion', this.ruleForm.Congregacion);
        data.append('RedSocial', this.ruleForm.RedSocial);
        //Añadimos la imagen seleccionada
        data.append('File', this.file);

        //Añadimos el método POST dentro del formData
        // Como lo hacíamos desde un formulario simple _(no ajax)_
        data.append('_method', 'post');
        axios.post('/visitante/registrar',data).then(function (response) {
            me.Modal=false;
            Swal.fire('Visitante registrado','','success');
            me.listarVisitantes();
            
        })
        .catch(function (error) {
            // handle error
            Swal.fire('Ocurrio un error','','error');
        })
        .finally(function () {
            // always executed
        });
      },
      actualizarVisitante(){
        let me=this;
        axios.put('/visitante/actualizar',{
            'ID' : this.ID_Visitante,
            'Nombre' : this.ruleForm.Nombre,
            'Apellido_P' : this.ruleForm.Apellido_P,
            'Apellido_M' : this.ruleForm.Apellido_M,
            'Correo' : this.ruleForm.Correo,
            'Telefono' : this.ruleForm.Telefono,
            'Congregacion' : this.ruleForm.Congregacion,
            'RedSocial' : this.ruleForm.RedSocial,
        }).then(function (response) {
            me.Modal=false;
            Swal.fire('Visitante actualizado','','success');
            me.listarVisitantes();
        })
        .catch(function (error) {
            // handle error
            Swal.fire('Ocurrio un error','','error');
        })
        .finally(function () {
            // always executed
        });
      },
      mostrarModal(modelo,accion,data=[]) {
        switch(modelo){
          case 'visitante':{
              switch(accion){
                  case 'registrar':{
                    this.Seccion="first";
                    if(this.$refs.ruleForm){
                      this.resetForm('ruleForm'); 
                    }
                    this.limpiarCampos();
                    this.Accion=0;
                    this.AccionImagen = 0;    
                    this.tituloModal='Registrar visitante';
                    this.Modal = true;
                    break;
                  }
                  case 'actualizar':{
                    this.Seccion="first";
                    this.Accion=1;
                    this.AccionImagen = 1;
                    this.visible=false;
                    this.tituloModal='Actualizar visitante';
                    this.Modal = true;
                    this.ID_Visitante     =   data['id'];
                    this.ruleForm.Nombre         =   data['Nombre'];
                    this.ruleForm.Apellido_P         =   data['Apellido_P'];
                    this.ruleForm.Apellido_M =   data['Apellido_M'];
                    this.ruleForm.Correo =   data['Correo'];
                    this.ruleForm.Telefono =   parseInt(data['Telefono']);
                    this.ruleForm.Congregacion =   data['Congregacion'];
                    this.ruleForm.RedSocial =   data['RedSocial'];
                    this.Imagen         =   data['Imagen'];
                    this.srcList.push('img/'+data['Imagen']);
                    break;
                  }
              }
          }
      }   
        
      },
      limpiarCampos(){
        this.ruleForm.Nombre ='';
        this.ruleForm.Apellido_P ='';
        this.ruleForm.Apellido_M ='';
        this.ruleForm.Telefono ='';
        this.ruleForm.Correo ='';
        this.ruleForm.Congregacion ='';
        this.ruleForm.RedSocial ='';
      },
      cerrarModal(){
        this.Modal=false;
      },
      //funcionalidades, registrar, actualizar etc..
      listarVisitantes(){
          let me=this;
          var url = '/visitante';
          axios.get(url).then(function (response) {
              // handle success
              var respuesta = response.data;
              me.arrayVisitantes=respuesta.visitantes;
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
          this.ID_Articulo=0;
          this.Imagen='';
      },
    },
    mounted(){
      this.listarVisitantes();
    },
  }
</script>
<style >
  .img-inputer--large{
    width:220px;
    height:150px;
  }
    @media (max-width: 600px) {
  .facet_sidebar {
    display: none;
  }
}
     
</style>