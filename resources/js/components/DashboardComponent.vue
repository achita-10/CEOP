<template>
  <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <!-- <div class="container-fluid"> -->
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
                            :src="'public/img/'+fit.Imagen"
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
                        <a-col xs:="24" :sm="24" :md="12">
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