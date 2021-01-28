<template>
  <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <div class="container-fluid">
              <el-card class="box-card">
                <div slot="header" class="clearfix">
                  <span>Usuarios</span>
                  <el-button style="float: right; padding: 3px 0"  @click="mostrarModal('usuario','registrar')" type="text">Registrar</el-button>
                </div>
                <div  class="text item">
                  <el-table
                    :data="arrayUsuarios.filter(data => !search ||  data.Nombre.toLowerCase().includes(search.toLowerCase()) || data.Apellido_P.toLowerCase().includes(search.toLowerCase()) || data.Apellido_M.toLowerCase().includes(search.toLowerCase()) )"
                    style="width: 100%;" max-height="400">
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
                        <section style="text-align:center;">
                          <el-button
                          size="medium"
                          @click="mostrarModal('usuario','actualizar',scope.row)" type="primary" circle>
                            <i class="el-icon-edit"></i>
                          </el-button>
                        </section>
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
                        <el-form-item label="Genero" prop="Genero">
                          <el-radio-group v-model="ruleForm.Genero">
                            <el-radio :label="1">Hombre</el-radio>
                            <el-radio :label="2">Mujer</el-radio>
                          </el-radio-group>
                        </el-form-item>
                      </a-col>
                      <a-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Estado civil" prop="EstadoCivil">
                          <el-select  placeholder="Seleccione" v-model="ruleForm.EstadoCivil">
                            <el-option
                              v-for="civil in arrayEstadoCivil"
                              :key="civil.value"
                              :label="civil.label"
                              :value="civil.value">
                            </el-option>
                          </el-select>
                        </el-form-item>
                      </a-col>
                      <a-col xs:="24" :sm="12" :md="8">
                        <el-form-item label="Fecha de nacimiento" prop="FechaNac">
                            <el-date-picker
                              v-model="ruleForm.FechaNac"
                              type="date"
                              value-format="yyyy-MM-dd"
                              placeholder="seleccione">
                            </el-date-picker>
                        </el-form-item>
                      </a-col>
                      <a-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Usuario" prop="Usuario">
                          <el-input   v-model="ruleForm.Usuario"></el-input>
                        </el-form-item>
                      </a-col>
                      <a-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Contraseña" prop="Contraseña">
                          <el-input type="password" v-model="ruleForm.Contraseña" ></el-input>
                        </el-form-item>
                      </a-col>
                      <a-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Confirmar" prop="checkPass">
                          <el-input type="password" v-model="ruleForm.checkPass"></el-input>
                        </el-form-item>
                      </a-col>
                      <a-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Rol" prop="Rol">
                          <el-select  placeholder="Seleccione" v-model="ruleForm.Rol">
                            <el-option
                              v-for="rol in arrayRoles"
                              :key="rol.id"
                              :label="rol.Nombre"
                              :value="rol.id">
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
<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'
import VueEasyLightbox from 'vue-easy-lightbox'
   export default {
    data() {
      var validatePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('Por favor ingrese una contraseña'));
        } else {
          if (this.ruleForm.checkPass !== '') {
            this.$refs.ruleForm.validateField('checkPass');
          }
          callback();
        }
      };
      var validatePass2 = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('Por favor ingrese la contraseña nuevamente'));
        } else if (value !== this.ruleForm.Contraseña) {
          callback(new Error('Las contraseñas no coinciden'));
        } else {
          callback();
        }
      };
      return { 
        //Roles
        arrayRoles:[],
        //tabs
        Seccion:'first',
        //tabla
        search:'',
        //estado civil
        arrayEstadoCivil: [{
          value: '1',
          label: 'Soltero(a)'
        }, {
          value: '2',
          label: 'Casado(a)'
        }, {
          value: '3',
          label: 'Divorciado(a)'
        }, {
          value: '4',
          label: 'Viudo(a)'
        }, {
          value: '5',
          label: 'Unión libre'
        }],
        //Articulo
        arrayUsuarios:[],
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
          Genero:'',
          EstadoCivil:'',
          FechaNac:'',
          Usuario:'',
          Contraseña:'',
          checkPass:'',
          Rol:'',

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
          Usuario:[
            { required: true, message: 'Por favor ingrese un usuario', trigger: 'change' },
            { min: 4, message: 'La longitud debe ser mayor 3 caracteres', trigger: 'blur' },
          ],
          Contraseña: [
            { validator: validatePass, trigger: 'blur' }
          ],
          checkPass: [
            { validator: validatePass2, trigger: 'blur' }
          ],
          Rol: [
            { required: true, message: 'Por favor seleccione un rol', trigger: ['change','blur'] },
          ],
        }
      };
    },
    components: {   
      VueEasyLightbox
    },
    methods: {
      
      //formulario
      submitForm(formName) {
        this.$refs[formName].validate(valid => {
          if (valid) {
            if(this.Accion==0){
              this.Titulo='¿Desea registrar al usuario?';
            }else{
              this.Titulo='¿Desea actualizar al usuario?';
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
                  me.registrarUsuario();
                }else{
                  me.actualizarUsuario();
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
      registrarUsuario(){
        let me=this;
        //Creamos el formData
        var data = new  FormData();
        data.append('Nombre', this.ruleForm.Nombre);
        data.append('Apellido_P', this.ruleForm.Apellido_P);
        data.append('Apellido_M', this.ruleForm.Apellido_M);
        data.append('Genero', this.ruleForm.Genero);
        data.append('EstadoCivil', this.ruleForm.EstadoCivil);
        data.append('FechaNac', this.ruleForm.FechaNac);
        data.append('Usuario', this.ruleForm.Usuario);
        data.append('Contraseña', this.ruleForm.Contraseña);
        data.append('Rol', this.ruleForm.Rol);

        //Añadimos el método POST dentro del formData
        // Como lo hacíamos desde un formulario simple _(no ajax)_
        data.append('_method', 'post');
        axios.post('/usuario/registrar',data).then(function (response) {
            me.Modal=false;
            Swal.fire('Usuario registrado','','success');
            me.listarUsuarios();
            
        })
        .catch(function (error) {
            // handle error
            Swal.fire('Ocurrio un error','','error');
        })
        .finally(function () {
            // always executed
        });
      },
      actualizarUsuario(){
        let me=this;
        axios.put('/usuario/actualizar',{
            'ID' : this.ID_Visitante,
            'Nombre' : this.ruleForm.Nombre,
            'Apellido_P' : this.ruleForm.Apellido_P,
            'Apellido_M' : this.ruleForm.Apellido_M,
            'Genero' : this.ruleForm.Genero,
            'EstadoCivil' : this.ruleForm.EstadoCivil,
            'FechaNac' : this.ruleForm.FechaNac,
            'Usuario' : this.ruleForm.Usuario,
            'Contraseña' : this.ruleForm.Contraseña,
            'Rol' : this.ruleForm.Rol,
        }).then(function (response) {
            me.Modal=false;
            Swal.fire('Usuario actualizado','','success');
            me.listarUsuarios();
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
        let estadocivil=0;
        this.listarRoles();
        switch(modelo){
          case 'usuario':{
              switch(accion){
                  case 'registrar':{
                    this.Seccion="first";
                    if(this.$refs.ruleForm){
                      this.resetForm('ruleForm'); 
                    }
                    this.limpiarCampos();
                    this.Accion=0;
                    this.AccionImagen = 0;    
                    this.tituloModal='Registrar usuario';
                    this.Modal = true;
                    break;
                  }
                  case 'actualizar':{
                    if(data['id']===1){
                      Swal.fire('No se permite editar la información','','warning');
                    }else{
                      if(this.$refs.ruleForm){
                        this.resetForm('ruleForm'); 
                      }
                      this.Accion=1;
                      this.AccionImagen = 1;
                      this.visible=false;
                      this.tituloModal='Actualizar usuario';
                      this.Modal = true;
                      this.ID_Visitante     =   data['id'];
                      this.ruleForm.Nombre         =   data['Nombre'];
                      this.ruleForm.Apellido_P         =   data['Apellido_P'];
                      this.ruleForm.Apellido_M =   data['Apellido_M'];
                      this.ruleForm.Genero =   data['Genero'];
                      if(data['EstadoCivil']!=null){
                        estadocivil=data['EstadoCivil'];
                      }
                      this.ruleForm.EstadoCivil =   parseInt(estadocivil);
                      this.ruleForm.FechaNac =   data['FechaNac'];
                      this.ruleForm.Usuario =   data['usuario'];
                      // this.ruleForm.Contraseña =   data['password'];
                      // this.ruleForm.checkPass =   data['password'];
                      this.ruleForm.Rol =   data['ID_Rol'];
                    }
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
        this.ruleForm.Genero ='';
        this.ruleForm.EstadoCivil ='';
        this.ruleForm.FechaNac ='';
        this.ruleForm.User ='';
        this.ruleForm.Pass ='';
        this.ruleForm.checkPass ='';
        this.ruleForm.Rol ='';
      },
      cerrarModal(){
        this.Modal=false;
      },
      //funcionalidades, registrar, actualizar etc..
      listarUsuarios(){
          let me=this;
          var url = '/usuario';
          axios.get(url).then(function (response) {
              // handle success
              var respuesta = response.data;
              me.arrayUsuarios=respuesta.usuarios;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
          .finally(function () {
              // always executed
          });
      },
      listarRoles(){
          let me=this;
          var url = '/rol';
          axios.get(url).then(function (response) {
              // handle success
              var respuesta = response.data;
              me.arrayRoles=respuesta.roles;
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
      this.listarUsuarios();
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