<template>
  <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <!-- <div class="container-fluid"> -->
              <el-row :gutter="12">
                    <el-col :xs="24" :sm="12" :md="6"  >
                      <el-card class="box-card" shadow="hover">
                        <div slot="header" class="clearfix">
                          <span>Miembros</span>
                        </div>
                        <div  class="text item">
                          Miembros activos: <strong>{{ActivosM.length}}</strong> <br>
                          Miembros inactivos: <strong>{{InactivosM.length}}</strong> <br>
                          
                        </div>
                      </el-card>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="6" >
                      <el-card class="box-card" shadow="hover">
                        <div slot="header" class="clearfix">
                          <span>Iglesia</span>
                        </div>
                        <div  class="text item">
                          Miembros bautizados: <strong>{{Bautizados.length}}</strong> <br>
                          Miembros no bautizados: <strong>{{NOBautizos.length}}</strong> 
                        </div>
                      </el-card>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="6" >
                      <el-card class="box-card" shadow="hover">
                        <div slot="header" class="clearfix">
                          <span>Grupos y Ministerios</span>
                        </div>
                        <div  class="text item">
                          Grupos: <strong>{{Grupos.length}}</strong> <br>
                          Ministerios: <strong>{{Ministerios.length}}</strong>
                        </div>
                      </el-card>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="6" >
                      <el-card class="box-card" shadow="hover">
                        <div slot="header" class="clearfix">
                          <span>Extra</span>
                        </div>
                        <div  class="text item">
                          Miembros fallecidos: <strong>{{Fallecidos.length}}</strong> <br>
                          Visitantes: <strong>{{Visitantes.length}}</strong>
                        </div>
                      </el-card>
                    </el-col>
                  </el-row>
              <el-card class="box-card">
                <div slot="header" class="clearfix">
                  <span>Inicio</span>
                  <el-button style="float: right; padding: 3px 0"  @click="mostrarModal('slider','registrar')" type="text">Registrar</el-button>
                  
                </div>
                <div  class="text item">
                  
                  <el-carousel :interval="4000" type="card" :height="altura">
                    <el-carousel-item v-for="fit in arrayImagenes" :key="fit.id">
    
                      <div class="demo-image" >
                        <div class="block" >
                          <el-image
                            :style="'width: 100%; height:'+altura+';'"
                            :src="'img/'+fit.Imagen"
                            ></el-image>
                        </div>
                      </div>
                    </el-carousel-item>
                  </el-carousel>
                </div>
              </el-card>
              <a-modal v-model="Modal" :title="tituloModal" on-ok="handleOk">
                <template slot="footer">
                    <a-button key="back" @click="cerrarModal" >
                    Regresar
                    </a-button>
                    <el-button key="" type="success"  @click="guardarImagen()">
                    Guardar
                    </el-button>
                </template>
                <el-form  status-icon  label-width="120px" class="demo-ruleForm">
                    <a-row :gutter="16">
                        <a-col :xs="24" :sm="24" :md="12">
                          <img-inputer class="img-inputer--large" v-model="file" theme="light" size="large"/>
                        </a-col>
                    </a-row>
                </el-form>
            </a-modal>    
            <!-- </div> -->
        </div>
        
    </main>
</template>
<script>
  import Swal from 'sweetalert2/dist/sweetalert2.js'
  import VueEasyLightbox from 'vue-easy-lightbox'
   export default {
    data() {
      return { 
        Grupos:[],
        ActivosM:[],
        Ministerios:[],
        InactivosM:[],
        Bautizados:[],
        NOBautizos:[],
        Fallecidos:[],
        Visitantes:[],
        altura:'300px',
        //img slider
        tamaño:'fill',
        //tabla
        search:'',
        //Articulo
        arrayImagenes:[],
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
      }
    },
    components: {   
      VueEasyLightbox
    },
    methods: {
      listarGrupos(){
        let me=this;
        var url = '/grupo';
        axios.get(url).then(function (response) {
            // handle success
            var respuesta = response.data;
            me.Grupos=respuesta.grupos;
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
            me.ActivosM=respuesta.activos;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .finally(function () {
            // always executed
        });
      },
      listarMinisterios(){
        let me=this;
        var url = '/ministerio';
        axios.get(url).then(function (response) {
            // handle success
            var respuesta = response.data;
            me.Ministerios=respuesta.ministerios;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .finally(function () {
            // always executed
        });
      },
      listarMiembrosInactivos(){
        let me=this;
        var url = '/miembro/inactivo';
        axios.get(url).then(function (response) {
            // handle success
            var respuesta = response.data;
            me.InactivosM=respuesta.inactivos;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .finally(function () {
            // always executed
        });
      },
      listarBautizados(){
        let me=this;
        var url = '/bautizados';
        axios.get(url).then(function (response) {
            // handle success
            var respuesta = response.data;
            me.Bautizados=respuesta.bautizados;
            
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .finally(function () {
            // always executed
        });
      },
      listarNoBautizados(){
        let me=this;
        var url = '/nobautizados';
        axios.get(url).then(function (response) {
            // handle success
            var respuesta = response.data;
            me.NOBautizos=respuesta.nobautizados;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .finally(function () {
            // always executed
        });
      },
      listarDecesos(){
        let me=this;
        var url = '/iglesia';
        axios.get(url).then(function (response) {
            // handle success
            var respuesta = response.data;
            me.Fallecidos=respuesta.decesos;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .finally(function () {
            // always executed
        });
      },
      listarVisitantes(){
          let me=this;
          var url = '/visitante';
          axios.get(url).then(function (response) {
              // handle success
              var respuesta = response.data;
              me.Visitantes=respuesta.visitantes;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
          .finally(function () {
              // always executed
          });
      },
      listarSlider(){
        let me=this;
          var url = '/slider';
          axios.get(url).then(function (response) {
              // handle success
              var respuesta = response.data;
              me.arrayImagenes=respuesta.sliders;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
          .finally(function () {
              // always executed
          });
      },
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
      guardarImagen() {
        let me=this;
        if(me.file != null){
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: '¿Desea guardar la imagen?',
            text: "Presione Aceptar o Cancelar para regresar",
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
              
              //Creamos el formData
              var data = new  FormData();
              //Añadimos la imagen seleccionada
              data.append('File', this.file);
              //Añadimos el método POST dentro del formData
              // Como lo hacíamos desde un formulario simple _(no ajax)_
              data.append('_method', 'post');
              axios.post('/slider/registrar',data).then(function (response) {
                  me.Modal=false;
                  Swal.fire('Imagen guardada','','success');
                  me.listarSlider();
                  
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
        }else{
          Swal.fire('Debe seleccionar un archivo','','warning');
        }
      },
      mostrarModal() {
        this.file=null;
        this.AccionImagen = 0;    
        this.tituloModal='Registrar Imagen';
        this.Modal = true;  
      },
      cerrarModal(){
        this.Modal=false;
      },
      
    },
    mounted(){
      this.listarSlider();
      this.listarGrupos();
      this.listarMiembros();
      this.listarMinisterios();
      this.listarMiembrosInactivos();
      this.listarBautizados();
      this.listarNoBautizados();
      this.listarDecesos();
      this.listarVisitantes();
    },
  }
</script>
<style >
  .el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }
     
</style>