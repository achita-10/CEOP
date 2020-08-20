@extends('Principal')
@section('contenido')
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
    
@endsection