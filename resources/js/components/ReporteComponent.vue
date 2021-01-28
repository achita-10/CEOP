<template>
    <!-- ### $App Screen Content ### -->
    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            <div class="container-fluid">
              <el-card class="box-card" >
                <div slot="header" class="clearfix">
                    <span >Reportes </span>
                    <br>
                    <template v-if="tag==0 || tag==1 || tag==2 || tag==3 || tag==4 || tag==5 ">
                      <span class="demonstration">Rango de Fecha</span>
                      <el-date-picker
                        size="small"
                        @change="registrosRango()"
                        v-model="Manual"
                        type="daterange"
                        range-separator="a"
                        start-placeholder="Fecha inicio"
                        end-placeholder="Fecha fin"
                        value-format="yyyy-MM-dd"
                        :disabled="Rango"
                        >
                      </el-date-picker>
                      <!-- <span class="demonstration">Día específico</span>
                      <el-date-picker
                        size="small"
                        @change="registrosDia()"
                        v-model="FechaIndividual"
                        :disabled="Dia"
                        type="date"
                        placeholder="Seleccione Día"
                        value-format="yyyy-MM-dd"
                        >
                      </el-date-picker> -->
                    </template>
                    <template v-if="tag==0 || tag==1 || tag==2 || tag==3 || tag==4 || tag==5 ">
                        <el-link @click="pdf()" type="danger">PDF</el-link>
                    </template>
                    <template v-if="tag==0 ">
                      <vue-excel-xlsx
                        :data="arrayBautizos"
                        :columns="columns"
                        :filename="'Bautizados_'+Fecha"
                        :sheetname="'Bautizados'"
                        class="btn btn-default"
                        >
                        Excel
                      </vue-excel-xlsx>
                    </template>
                    <template v-else-if="tag==1">
                      <vue-excel-xlsx
                          :data="arrayBautizos"
                          :columns="columns"
                          :filename="'NoBautizados_'+Fecha"
                          :sheetname="'No Bautizados'"
                          class="btn btn-default"
                          >
                          Excel
                      </vue-excel-xlsx>
                    </template>
                    <template v-else-if="tag==2">
                      <vue-excel-xlsx
                          :data="arrayBautizos"
                          :columns="columns"
                          :filename="'Decesos_'+Fecha"
                          :sheetname="'Decesos'"
                          class="btn btn-default"
                          >
                          Excel
                      </vue-excel-xlsx>
                    </template>
                    <template v-else-if="tag==3">
                      <vue-excel-xlsx
                          :data="arrayBautizos"
                          :columns="columnsCumples"
                          :filename="'Cumpleaños_'+Fecha"
                          :sheetname="'Cumpleaños'"
                          class="btn btn-default"
                          >
                          Excel
                      </vue-excel-xlsx>
                    </template>
                    <template v-else-if="tag==4">
                      <vue-excel-xlsx
                          :data="arrayBautizos"
                          :columns="columnsMiembrosA"
                          :filename="'MiembrosActivos_'+Fecha"
                          :sheetname="'Miembros Activos'"
                          class="btn btn-default"
                          >
                          Excel
                      </vue-excel-xlsx>
                    </template>
                    <template v-else-if="tag==5">
                      <vue-excel-xlsx
                          :data="arrayBautizos"
                          :columns="columnsMiembrosI"
                          :filename="'MiembrosInactivos_'+Fecha"
                          :sheetname="'Miembros Inactivos'"
                          class="btn btn-default"
                          >
                          Excel
                      </vue-excel-xlsx>
                    </template>
                </div>
                <el-tabs type="border-card" @tab-click="verificar()"  v-model="tag" :tab-position="tabPosition" style="height: 330px;">
                    <el-tab-pane  label="Bautizados">
                        
                    </el-tab-pane>
                    <el-tab-pane  label="No Bautizados">
                        
                    </el-tab-pane>
                    <el-tab-pane label="Decesos">
                        
                    </el-tab-pane>
                    <el-tab-pane label="Cumpleaños">
                        
                    </el-tab-pane>
                    <el-tab-pane label="Miembros Activos">
                        
                    </el-tab-pane>
                    <el-tab-pane label="Miembros Inactivos">
                        
                    </el-tab-pane>
                    <el-table
                        v-if="tag==0 || tag==1 || tag==2 || tag==3 || tag==4 || tag==5 "
                        :data="arrayBautizos.filter(data => !search ||  data.Nombre.toLowerCase().includes(search.toLowerCase()) || data.Apellido_P.toLowerCase().includes(search.toLowerCase()) || data.Apellido_M.toLowerCase().includes(search.toLowerCase()) )"
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
                                :preview-src-list="srcList">
                            </el-image>
                            </div>
                        </template>
                        </el-table-column>
                        <el-table-column
                        label="Nombre"
                        prop="Nombre">
                        </el-table-column>
                        <el-table-column
                        label="Apellidos"
                        prop="Apellido_P">
                            <template slot-scope="scope">
                                {{scope.row.Apellido_P + " " + scope.row.Apellido_M}}
                            </template>
                        </el-table-column>
                        <el-table-column
                        label="Genero">
                            <template slot-scope="scope">
                                <span style="margin-left: 10px" v-if="scope.row.Genero==1">HOMBRE</span>
                                <span style="margin-left: 10px" v-else>MUJER</span>
                            </template>
                        </el-table-column>
                        <el-table-column
                        align="right">
                            <template slot="header" slot-scope="scope">
                                <el-input
                                v-model="search"
                                size="mini"
                                placeholder="Buscar"/>
                            </template>
                            <template slot-scope="scope" >
                                <section v-if="tag==3">
                                    <p style="text-align:center;"><i class="el-icon-time"></i>{{scope.row.FechaNac}} </p><br>
                                    
                                </section>
                                <section v-else-if="tag==4 || tag==5" style="text-align:center;">
                                    <el-button
                                        title="PDF"
                                        size="small"
                                        @click="pdfMiembroIndividual(scope.row.id)" type="danger" circle>
                                        <i class="el-icon-document"></i>
                                    </el-button>
                                </section>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-tabs>
                  
              </el-card>
                
            </div>
        </div>
        
    </main>
</template>

<script>
 import Swal from 'sweetalert2/dist/sweetalert2.js'
    export default {
         data(){
            return{
                Edad:0,
                //GM
                arrayGrupos:[],
                arrayMinisterios:[],
                //imagen
                visible:false,
                Imagen : '',
                file : null,
                imgs: '',  // Img Url , string or Array
                index: 0,   // default
                srcList: [],
                //tabs
                tabPosition: 'left',
                tag:'',
                //tabla
                search:'',
                //variables
                arrayBautizos:[],
                //fechas
                Fecha:'',
                FechaIndividual:'',
                Dia:false,
                Rango:false,
                Manual:'',
                //Excell
                longitud: 0, 
                Contar:0,
                Evaluar:0,
                
                columnsMiembrosI:[
                    {
                        label: "#",
                        field: "id",
                        dataFormat: this.contador
                    },
                    {
                        label: "Nombre",
                        field: "Nombre",
                    },
                    {
                        label: "Apellido Paterno",
                        field: "Apellido_P",
                    },
                    {
                        label: "Apellido Materno",
                        field: "Apellido_M",
                    },
                    {
                        label: "Motivo",
                        field: "Motivo",
                    }
                ],
                columnsMiembrosA:[
                    {
                        label: "#",
                        field: "id",
                        dataFormat: this.contador
                    },
                    {
                        label: "Nombre",
                        field: "Nombre",
                    },
                    {
                        label: "Apellido Paterno",
                        field: "Apellido_P",
                    },
                    {
                        label: "Apellido Materno",
                        field: "Apellido_M",
                    },
                    {
                        label: "Grupo",
                        field: "Grupo",
                        dataFormat: this.Grupo
                    },
                    {
                        label: "Ministerio",
                        field: "Ministerio",
                        dataFormat: this.Ministerio
                    },
                ],
                columnsCumples:[
                    {
                        label: "#",
                        field: "id",
                        dataFormat: this.contador
                    },
                    {
                        label: "Nombre",
                        field: "Nombre",
                    },
                    {
                        label: "Apellido Paterno",
                        field: "Apellido_P",
                    },
                    {
                        label: "Apellido Materno",
                        field: "Apellido_M",
                    },
                    {
                        label: "Fecha de Nacimiento",
                        field: "FechaNac",
                    },
                    {
                        label: "Fecha de Ingreso",
                        field: "FechaIngreso",
                    },
                ],
                columnsAsistencias:[
                    {
                        label: "#",
                        field: "id",
                        dataFormat: this.contador
                    },
                    {
                        label: "Nombre",
                        field: "Nombre",
                    },
                    {
                        label: "Apellido Paterno",
                        field: "Apellido_P",
                    },
                    {
                        label: "Apellido Materno",
                        field: "Apellido_M",
                    },
                    {
                        label: "Fecha de Asistencia",
                        field: "Fecha",
                    },
                    {
                        label: "Fecha de Nacimiento",
                        field: "FechaNac",
                    },
                    {
                        label: "Fecha de Ingreso",
                        field: "FechaIngreso",
                    },
                    {
                        label: "Grupo",
                        field: "Grupo",
                        dataFormat: this.Grupo
                    },
                    {
                        label: "Ministerio",
                        field: "Ministerio",
                        dataFormat: this.Ministerio
                    },
                ],
                columns: [
                {
                    label: "#",
                    field: "id",
                    dataFormat: this.contador
                },
                {
                    label: "Nombre",
                    field: "Nombre",
                },
                {
                    label: "Apellido Paterno",
                    field: "Apellido_P",
                },
                {
                    label: "Apellido Materno",
                    field: "Apellido_M",
                },
                {
                    label: "Iglesia",
                    field: "Iglesia",
                },
                {
                    label: "Fecha de Bautizo",
                    field: "FechaBautizo",
                },
                {
                    label: "Genero",
                    field: "Genero",
                    dataFormat: this.Genero
                },
                {
                    label: "Estado Civil",
                    field: "EstadoCivil",
                    dataFormat: this.EstadoCivil

                },
                {
                    label: "Fecha de Nacimiento",
                    field: "FechaNac",
                },
                {
                    label: "Fecha de deceso",
                    field: "FechaDeceso",
                },
                {
                    label: "Fecha de Ingreso",
                    field: "FechaIngreso",
                },
                {
                    label: "Fecha de Conversión",
                    field: "FechaConversion",
                },
                {
                    label: "Grupo",
                    field: "Grupo",
                    dataFormat: this.Grupo
                },
                {
                    label: "Ministerio",
                    field: "Ministerio",
                    dataFormat: this.Ministerio
                },
                {
                    label: "Correo",
                    field: "Correo",
                },
                {
                    label: "Telefono",
                    field: "Telefono",
                },
                {
                    label: "Dirección",
                    field: "Direccion",
                },
                {
                    label: "Ocupación",
                    field: "Ocupacion",
                },
                {
                    label: "Papá",
                    field: "Padre",
                },
                {
                    label: "Mamá",
                    field: "Madre",
                }
                ],
            }
        },
        computed:{
            verifica: function(){
                this.longitud=this.arrayBautizos.length;
            },
        },
        methods:{
           
            pdfMiembroIndividual(id){
                window.open('/miembro/pdf/individual?ID='+id);
            },
            listarBautizados(){
                let me=this;
                var url = '/bautizados';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayBautizos=respuesta.bautizados;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            //PDF
            pdf(){
                if(this.arrayBautizos<=0){
                    Swal.fire('No existen registros de busqueda','','info');
                }else{
                    if(this.Manual!==null && this.Manual !=="" && this.Manual.length>0  ){
                        window.open('/miembro/pdf/rango?Fechas='+this.Manual+'&Tipo='+this.tag);
                    }else if(this.FechaIndividual!=null && this.FechaIndividual!="" && ( this.Manual==null || this.Manual =="")){
                        window.open('/miembro/pdf/dia?Fecha='+this.FechaIndividual+'&Tipo='+this.tag);
                    }else {
                        window.open('/miembro/pdf/sinfecha?Tipo='+this.tag);
                    }
                }
            },
            //Datepicker
            registrosRango(){
                let me=this;
                if(this.Manual!=null){
                    me.Rango=false;
                    me.Dia=true;
                    axios.get('/bautizos/filtrados?Inicio='+me.Manual[0]+'&Fin='+me.Manual[1]+'&Tipo='+me.tag
                ).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayBautizos=respuesta.rango;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
                }else{
                    this.verificar();
                    me.Dia=false;
                }
            },
            //Datepicker
            registrosDia(){
                let me=this;
                if(this.FechaIndividual!=null){
                me.Dia=false;
                me.Rango=true;
                axios.get('/bautizos/dia?Dia='+me.FechaIndividual+'&Tipo='+me.tag
                ).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayBautizos=respuesta.dia;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
                }else{
                    this.verificar();
                    me.Rango=false;
                }
            },
            //Excel
            contador(value){
                var longitud = this.arrayBautizos.length;
                // this.Contar++;
                if(longitud<=this.Contar){
                    this.Contar=0;
                    this.Contar++;
                }else{
                    this.Contar++;
                }
                    return this.Contar;
            },
            Genero(value){
                if(value=='1'){
                    return "Hombre";
                }else{
                    return "Mujer";
                }
            },
            EstadoCivil(value){
                if(value=='1'){
                    return "Soltero(a)";
                }else if(value=='2'){
                    return "Casado(a)";
                }else if(value=='3'){
                    return "Divorciado(a)";
                }else if(value=='4'){
                    return "Viudo(a)";
                }else{
                    return "Unión libre";
                }
            },
            Grupo(value){
                for(var i=0; i<this.arrayGrupos.length;i++){
                    if(this.arrayGrupos[i].id==value){
                        return this.arrayGrupos[i].Grupo;
                    }
                }
            },
            Ministerio(value){
                for (let i = 0; i < this.arrayMinisterios.length; i++) {
                    if(this.arrayMinisterios[i].id==value){
                        return this.arrayMinisterios[i].Ministerio;
                    }
                }
            },
            verificarExcel(){
                if(this.arrayBautizos.length<=0){
                    Swal.fire('No existes registros de busqueda','','info');
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
            verificar(){
                this.Manual='';
                this.arrayBautizos=[];
                this.Rango=false;
                this.Dia=false;
                this.FechaIndividual='';
                var d= new Date();
                var month = d.getMonth()+1;
                var day = d.getDate();

                var output = d.getFullYear() + '/' +
                    (month<10 ? '0' : '') + month + '/' +
                    (day<10 ? '0' : '') + day;
                this.Fecha= output;

                if(this.tag==0){
                    this.listarBautizados();
                }else if(this.tag==1){
                    this.listarNoBautizados();
                }else if(this.tag==2){
                    this.listarDecesos();
                }else if(this.tag==3){
                    this.listarCumpleaños();
                    this.calcularEdad();
                }else if(this.tag==4){
                    this.listarMiembrosActivos();
                }else {
                    this.listarMiembrosInactivos();
                }
            },
            listarMiembrosActivos(){
                let me=this;
                var url = '/miembro/activo';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayBautizos=respuesta.activos;
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
                    me.arrayBautizos=respuesta.inactivos;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            listarReporteGrupos(){
                let me=this;
                var url = '/grupo/reporte';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayBautizos=respuesta.reporte;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            listarReporteMinisterios(){
                let me=this;
                var url = '/ministerio/reporte';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayBautizos=respuesta.reporte;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            listarCumpleaños(){
                let me=this;
                var url = '/miembro/cumples';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayBautizos=respuesta.cumpleaños;
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
                    me.arrayBautizos=respuesta.decesos;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            listarAsistencias(){
                let me=this;
                var url = '/asistencia/listarAsistencias';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayBautizos=respuesta.asistencias;
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
                    me.arrayBautizos=respuesta.bautizados;
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
                    me.arrayBautizos=respuesta.nobautizados;
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
        },
        mounted() {
            this.listarBautizados();
            this.listarGrupos();
            this.listarMinisterios();
            this.CalcularFecha();
        }
    }
</script>
