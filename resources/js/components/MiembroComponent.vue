<template>
  <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <div class="container-fluid">
              <el-card class="box-card">
                <div slot="header" class="clearfix">
                  <span>Miembros</span>
                 
                  <el-button style="float: right; padding: 3px 0"  @click="mostrarModal('articulo','registrar')" type="text">Registrar</el-button>
                </div>
                <div  class="text item">
                  <el-table
                    :data="arrayMiembros.filter(data => !search ||  data.Nombre.toLowerCase().includes(search.toLowerCase()) || data.Apellido_P.toLowerCase().includes(search.toLowerCase()) || data.Apellido_M.toLowerCase().includes(search.toLowerCase()) )"
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
                    label="Genero"
                    prop="Genero">
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
                        @click="mostrarModal('articulo','actualizar',scope.row)" type="primary" circle><i class="el-icon-edit"></i></el-button>
                        
                    </template>
                    </el-table-column>
                  </el-table>
                </div>
              </el-card>
                <a-modal :width="800"  v-model="Modal" :title="tituloModal" on-ok="handleOk">
                  <template slot="footer" v-if="ActualizarImagen==0">
                      <el-button  v-if="AccionImagen==1" type="primary" @click="cambiarImagen()" >
                        Actualizar Imagen
                      </el-button>
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
                  <template slot="footer" v-else>
                    <el-button  type="primary"  @click="regresar()" >
                        Regresar
                      </el-button>
                      <el-button type="success"  @click="actualizarImagen()">
                        Actualizar
                      </el-button>
                  </template>
                  <el-form size="small" :label-position="labelPosition" status-icon :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
                    <a-row :gutter="16">
                      <el-tabs v-model="Seccion" >
                        <template v-if="ActualizarImagen==0">
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
                              <el-form-item label="" >
                                <template v-if="AccionImagen==0 || ActualizarImagen==1">
                                    <img-inputer class="img-inputer--large" v-model="file" theme="light" size="large"/>
                                </template>
                                <template v-else>
                                  <div class="demo-image__preview">
                                    <el-image 
                                      style="width: 240px; height: 200px"
                                      :src="'public/img/'+Imagen" 
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
                              <el-form-item label="Dirección" prop="Direccion">
                                <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Direccion"></el-input>
                              </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8" >
                              <el-form-item label="Ocupación" prop="Ocupacion">
                                <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Ocupacion"></el-input>
                              </el-form-item>
                            </a-col>
                          </el-tab-pane>
                          <el-tab-pane label="Familiares" name="third">
                            <a-col :xs="24" :sm="12" :md="8" >
                              <el-form-item label="Nombre del Padre" prop="Padre">
                                <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Padre"></el-input>
                              </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8" >
                              <el-form-item label="Nombre de la Madre" prop="Madre">
                                <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Madre"></el-input>
                              </el-form-item>
                            </a-col>
                          </el-tab-pane>
                          <el-tab-pane label="Iglesia" name="fourth">
                            <a-col :xs="24" :sm="12" :md="8" >
                              <el-form-item label="Fecha de ingreso" prop="FechaIngreso">
                                <el-date-picker
                                  v-model="ruleForm.FechaIngreso"
                                  type="date"
                                  value-format="yyyy-MM-dd"
                                  placeholder="seleccione">
                                </el-date-picker>
                              </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8" >
                              <el-form-item label="Fecha de conversión" prop="FechaConversion">
                                <el-date-picker
                                  v-model="ruleForm.FechaConversion"
                                  type="date"
                                  value-format="yyyy-MM-dd"
                                  placeholder="seleccione">
                                </el-date-picker>
                              </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8">
                              <el-form-item label="Bautizado" prop="Bautizado">
                                <el-select  placeholder="Seleccione" v-model="ruleForm.Bautizado">
                                  <el-option
                                    label="Si"
                                    value="1">
                                  </el-option>
                                  <el-option
                                    label="No"
                                    value="2">
                                  </el-option>
                                </el-select>
                              </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8" >
                              <el-form-item label="Fecha de bautizo" prop="FechaBautizo">
                                <el-date-picker
                                  v-model="ruleForm.FechaBautizo"
                                  type="date"
                                  value-format="yyyy-MM-dd"
                                  placeholder="seleccione">
                                </el-date-picker>
                              </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8" >
                              <el-form-item label="Nombre de la iglesia" prop="Iglesia">
                                <el-input  suffix-icon="el-icon-info"  v-model="ruleForm.Iglesia"></el-input>
                              </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8">
                              <el-form-item label="Grupo" prop="Grupo">
                                <el-select   v-model="ruleForm.Grupo">
                                  <el-option  value="">Seleccione</el-option>
                                  <el-option
                                    v-for="grupo in arrayGrupos"
                                    :key="grupo.id"
                                    :label="grupo.Nombre"
                                    :value="grupo.id">
                                  </el-option>
                                  
                                </el-select>
                              </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8">
                              <el-form-item label="Ministerio" prop="Ministerio">
                                <el-select   v-model="ruleForm.Ministerio">
                                  <el-option  value="">Seleccione</el-option>
                                  <el-option
                                    v-for="ministerio in arrayMinisterios"
                                    :key="ministerio.id"
                                    :label="ministerio.Nombre"
                                    :value="ministerio.id">
                                  </el-option>
                                  
                                </el-select>
                              </el-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="12" :md="8" >
                              <el-form-item label="Fecha de deceso" prop="FechaDeceso">
                                <el-date-picker
                                  v-model="ruleForm.FechaDeceso"
                                  type="date"
                                  value-format="yyyy-MM-dd"
                                  placeholder="seleccione">
                                </el-date-picker>
                              </el-form-item>
                            </a-col>
                          </el-tab-pane>
                        </template>
                        <template v-else>
                          <a-col :xs="24" :sm="12" :md="8">
                              <el-form-item label="" >
                                <template v-if="AccionImagen==0 || ActualizarImagen==1">
                                    <img-inputer class="img-inputer--large" v-model="file" theme="light" size="large"/>
                                </template>
                                <template v-else>
                                  <div class="demo-image__preview">
                                    <el-image 
                                      style="width: 240px; height: 200px"
                                      :src="'public/img/'+Imagen" 
                                      :preview-src-list="srcList">
                                    </el-image>
                                  </div>
                                </template>
                              </el-form-item>
                            </a-col>
                        </template>
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
        //grupos
        arrayGrupos:[],
        //tabs
        Seccion:'first',
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
        //ministerios
        arrayMinisterios:[],
        //tabla
        search:'',
        //Articulo
        arrayMiembros:[],
        ID_Miembro:0,
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
          Genero: 0,
          EstadoCivil: '',
          FechaNac:'',
          Correo:'',
          Telefono:'',
          Direccion:'',
          Ocupacion:'',
          Padre:'',
          Madre:'',
          FechaIngreso:'',
          FechaConversion:'',
          Bautizado:'',
          FechaBautizo:'',
          Iglesia:'',
          Grupo:'',
          Ministerio:'',
          FechaDeceso:'',

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
          Genero: [
            { required: true, message: 'Por favor ingrese el genero', trigger: 'change || blur' },
            { type: 'number', message: 'El precio solo puede ser valor númerico', trigger: 'blur' }
          ],
          EstadoCivil: [
            { required: true, message: 'Por favor ingrese el estado civil', trigger: 'change' },
          ],
          FechaNac: [
            {  required: true, message: 'Por favor seleccione una fecha', trigger: 'change' }
          ],
          Correo:[
            { required: false, message: 'Puede o no ingresar el correo', trigger: 'blur' },
            { type: 'email', message: 'Por favor ingrese un correo valido', trigger: ['blur', 'change'] }
          ],
          Telefono:[
            {validator: checkTelefono,trigger:'blur'}
          ],
          Ocupacion:[
            { required: false, message: 'Puede o no ingresar la ocupación', trigger: 'blur' },
            { min: 4, message: 'La longitud debe ser mayor a 3 caracteres', trigger: 'blur' }
          ],  
          Direccion:[
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
      format(percentage) {
        return percentage === 100 ? 'Full' : `${percentage}%`;
      },
      //imagen
      showSingle() {
          this.imgs = 'public/img/' + this.Imagen;
          this.show()
      },
      show() {
          this.visible = true
      },
      handleHide() {
          this.visible = false
      },
      //formulario
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
      submitForm(formName) {
        this.$refs[formName].validate(valid => {
          if (valid) {
            if(this.Accion==0){
              this.Titulo='¿Desea registrar al miembro?';
            }else{
              this.Titulo='¿Desea actualizar al miembro?';
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
                  me.registrarMiembro();
                }else{
                  me.actualizarMiembro();
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
      registrarMiembro(){
        let me=this;
        //Creamos el formData
        var data = new  FormData();
        data.append('Nombre', this.ruleForm.Nombre);
        data.append('Apellido_P', this.ruleForm.Apellido_P);
        data.append('Apellido_M', this.ruleForm.Apellido_M);
        data.append('Genero', this.ruleForm.Genero);
        data.append('EstadoCivil', this.ruleForm.EstadoCivil);
        data.append('FechaNac', this.ruleForm.FechaNac);
        data.append('Correo', this.ruleForm.Correo);
        data.append('Telefono', this.ruleForm.Telefono);
        data.append('Direccion', this.ruleForm.Direccion);
        data.append('Ocupacion', this.ruleForm.Ocupacion);
        data.append('Padre', this.ruleForm.Padre);
        data.append('Madre', this.ruleForm.Madre);
        data.append('FechaIngreso', this.ruleForm.FechaIngreso);
        data.append('FechaConversion', this.ruleForm.FechaConversion);
        data.append('Bautizado', this.ruleForm.Bautizado);
        data.append('FechaBautizo', this.ruleForm.FechaBautizo);
        data.append('Iglesia', this.ruleForm.Iglesia);
        data.append('Grupo', this.ruleForm.Grupo);
        data.append('Ministerio', this.ruleForm.Ministerio);
        data.append('FechaDeceso', this.ruleForm.FechaDeceso);
        //Añadimos la imagen seleccionada
        data.append('File', this.file);

        //Añadimos el método POST dentro del formData
        // Como lo hacíamos desde un formulario simple _(no ajax)_
        data.append('_method', 'post');
        axios.post('/miembro/registrar',data).then(function (response) {
            me.Modal=false;
            Swal.fire('Miembro registrado','','success');
            me.listarMiembros();
            
        })
        .catch(function (error) {
            // handle error
            Swal.fire('Ocurrio un error','','error');
        })
        .finally(function () {
            // always executed
        });
      },
      actualizarMiembro(){
        let me=this;
        axios.put('/miembro/actualizar',{
            'ID' : this.ID_Miembro,
            'Nombre' : this.ruleForm.Nombre,
            'Apellido_P' : this.ruleForm.Apellido_P,
            'Apellido_M' : this.ruleForm.Apellido_M,
            'Genero' : this.ruleForm.Genero,
            'EstadoCivil' : this.ruleForm.EstadoCivil,
            'FechaNac' : this.ruleForm.FechaNac,
            'Correo' : this.ruleForm.Correo,
            'Telefono' : this.ruleForm.Telefono,
            'Direccion' : this.ruleForm.Direccion,
            'Ocupacion' : this.ruleForm.Ocupacion,
            'Padre' : this.ruleForm.Padre,
            'Madre' : this.ruleForm.Madre,
            'FechaIngreso' : this.ruleForm.FechaIngreso,
            'FechaConversion' : this.ruleForm.FechaConversion,
            'Bautizado' : this.ruleForm.Bautizado,
            'FechaBautizo' : this.ruleForm.FechaBautizo,
            'Iglesia' : this.ruleForm.Iglesia,
            'Grupo' : this.ruleForm.Grupo,
            'Ministerio' : this.ruleForm.Ministerio,
            'FechaDeceso' : this.ruleForm.FechaDeceso,
        }).then(function (response) {
            me.Modal=false;
            Swal.fire('Miembro actualizado','','success');
            me.listarMiembros();
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
        this.file=null;
        this.listarGrupos();
        this.listarMinisterios();
        
        switch(modelo){
          case 'articulo':{
              switch(accion){
                  case 'registrar':{
                    this.Seccion="first";
                    if(this.$refs.ruleForm){
                      this.resetForm('ruleForm'); 
                    }
                    this.limpiarCampos();
                    this.Accion=0;
                    this.AccionImagen = 0;    
                    this.tituloModal='Registrar Miembro';
                    this.Modal = true;
                    break;
                  }
                  case 'actualizar':{
                    this.ActualizarImagen=0;
                    this.Seccion="first";
                    this.Accion=1;
                    this.AccionImagen = 1;
                    this.visible=false;
                    this.tituloModal='Actualizar Miembro';
                    this.Modal = true;
                    this.ID_Miembro     =   data['id'];
                    this.ruleForm.Nombre         =   data['Nombre'];
                    this.ruleForm.Apellido_P         =   data['Apellido_P'];
                    this.ruleForm.Apellido_M =   data['Apellido_M'];
                    this.ruleForm.Genero =   data['Genero'];
                    this.ruleForm.EstadoCivil =   data['EstadoCivil'];
                    this.ruleForm.FechaNac =   data['FechaNac'];
                    this.ruleForm.Correo =   data['Correo'];
                    this.ruleForm.Telefono =   parseInt(data['Telefono']);
                    this.ruleForm.Direccion =   data['Direccion'];
                    this.ruleForm.Ocupacion =   data['Ocupacion'];
                    this.ruleForm.Padre =   data['Padre'];
                    this.ruleForm.Madre =   data['Madre'];
                    this.ruleForm.FechaIngreso =   data['FechaIngreso'];
                    this.ruleForm.FechaConversion =   data['FechaConversion'];
                    this.ruleForm.Bautizado =   data['Bautizado'];
                    this.ruleForm.FechaBautizo =   data['FechaBautizo'];
                    this.ruleForm.Iglesia =   data['Iglesia'];
                    this.ruleForm.Grupo =   data['Grupo'];
                    this.ruleForm.Ministerio =   data['Ministerio'];
                    this.ruleForm.FechaDeceso =   data['FechaDeceso'];
                    
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
        this.ruleForm.Correo='';
        this.ruleForm.Telefono='';
        this.ruleForm.Direccion='';
        this.ruleForm.Ocupacion='';
        this.ruleForm.Padre='';
        this.ruleForm.Madre='';
        this.ruleForm.FechaIngreso='';
        this.ruleForm.FechaConversion='';
        this.ruleForm.Bautizado='';
        this.ruleForm.FechaBautizo='';
        this.ruleForm.Iglesia='';
        this.ruleForm.Grupo='';
        this.ruleForm.Ministerio='';
        this.ruleForm.FechaDeceso='';
        this.ActualizarImagen   =   0;
      },
      cerrarModal(){
        this.Modal=false;
      },
      //funcionalidades, registrar, actualizar etc..
      actualizarImagen(){
        let me=this;
        if(me.file!=null){
          //Creamos el formData
          var data = new  FormData();
          data.append('ID', this.ID_Miembro);
          //Añadimos la imagen seleccionada
          data.append('File', this.file);
          //Añadimos el método POST dentro del formData
          // Como lo hacíamos desde un formulario simple _(no ajax)_
          data.append('_method', 'post');
          axios.post('/miembro/imagen',data).then(function (response) {
              Swal.fire('Imagen Actualizada','','success');
              me.cerrarModal();
              me.listarMiembros();
              
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
          .finally(function () {
              // always executed
          });
        }else{
          Swal.fire('Debe cargar una imagen','','warning');
        }
      },
      cambiarImagen(){
        let me = this;
        me.ActualizarImagen=1;
        me.tituloModal='Actualizar imagen';
      },
      regresar(){
          this.ActualizarImagen=0;
        this.tituloModal='Actualizar Miembro';

      },
      
      listarMiembros(){
          let me=this;
          var url = '/miembro';
          axios.get(url).then(function (response) {
              // handle success
              var respuesta = response.data;
              me.arrayMiembros=respuesta.miembros;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
          .finally(function () {
              // always executed
          });
      },
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
      listarCategorias(){
        // Make a request for a user with a given ID
        let me=this;
        var url = '/categoria/seleccionar_categoria';
        axios.get(url).then(function (response) {
            // handle success
            
            var respuesta = response.data;
            me.arrayCategoria=respuesta.categorias;
            //me.pagination = respuesta.pagination;
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
      this.listarMiembros();
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