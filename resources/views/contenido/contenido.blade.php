@extends('Principal')
@section('contenido')
    @if(Auth::check())   
        @if(Auth::user()->ID_Rol ==1)
            <template v-if="menu==0">
                <dashboard-component></dashboard-component>
            </template>
            <template v-if="menu==1">
                <miembro-component></miembro-component>
            </template>
            <template v-if="menu==2">
                <grupo-component></grupo-component>
            </template> 
            <template v-if="menu==3">
                <ministerio-component></ministerio-component>
            </template> 
            <template v-if="menu==4">
                <visitante-component></visitante-component>
            </template> 
            <template v-if="menu==5">
                <usuarios-component></usuarios-component>
            </template> 
            <template v-if="menu==6">
                <deceso-component></deceso-component>
            </template> 
            <template v-if="menu==7">
                <reporte-component></reporte-component>
            </template> 
        @endif

        @if(Auth::user()->ID_Rol ==2)
            <template v-if="menu==0">
                <dashboard-component></dashboard-component>
            </template>
            <template v-if="menu==1">
                <miembrodos-component></miembrodos-component>
            </template>
            <template v-if="menu==2">
                <grupodos-component></grupodos-component>
            </template>
            <template v-if="menu==3">
                <ministeriodos-component></ministeriodos-component>
            </template>
            <template v-if="menu==7">
                <reporte-component></reporte-component>
            </template> 
        @endif
    @endif
@endsection