<template>
  <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <div class="container-fluid">
              <el-card class="box-card">
                <div slot="header" class="clearfix">
                  <span>Decesos</span>
                </div>  
                <el-table
                  :data="arrayDecesos.filter(data => !search ||  data.Nombre.toLowerCase().includes(search.toLowerCase()) || data.Apellido_P.toLowerCase().includes(search.toLowerCase()) || data.Apellido_M.toLowerCase().includes(search.toLowerCase()) )"
                  style="width: 100%; " max-height="400">
                  <el-table-column
                  label="id"
                  prop="id">
                  </el-table-column>
                  <el-table-column
                  label="Foto"
                  prop="Imagen">
                    <template slot-scope="scope">
                      <div class="demo-image__preview">
                        <el-image 
                          style="width: 60px; height: 60px"
                          :src="'img/'+scope.row.Imagen" 
                          >
                        </el-image>
                        
                      </div>
                      <!-- {{srcList.push('img/'+scope.row.Imagen)}} -->
                    </template>
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
                      {{scope.row.FechaDeceso}}
                  </template>
                  </el-table-column>
                </el-table>
                
              </el-card>
            </div>
        </div>
        
    </main>
</template>
<script>
import Swal from 'sweetalert2/dist/sweetalert2.js'
   export default {
    data() {
      return { 
        //tabs
        Seccion:'first',
        //tabla
        search:'',
        //Articulo
        arrayDecesos:[],
        ID_Deceso:0,
      }
    },
    methods: {
      mensajeDeceso(data=[]){
        Swal.fire('El miembro '+data['Nombre']+' '+data['Apellido_P']+' '+data['Apellido_M']+' ha fallecido','Fecha de deceso: '+data['FechaDeceso'],'info');
      },
      listarDecesos(){
          let me=this;
          var url = '/iglesia';
          axios.get(url).then(function (response) {
              // handle success
              var respuesta = response.data;
              me.arrayDecesos=respuesta.decesos;
          })
          .catch(function (error) {
              // handle error
              console.log(error);
          })
          .finally(function () {
              // always executed
          });
      },
    },
    mounted(){
      this.listarDecesos();
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