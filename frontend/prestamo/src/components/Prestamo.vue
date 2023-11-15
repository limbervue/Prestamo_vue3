<script lang="ts" setup>

    import axios from "axios"
    import { onMounted, ref } from 'vue';

    let nombre = ref("")
    let dato = ref()
    let idd = ref()
    let eliminar_id = ref()
    let eliminar_name = ref()

    let dialog_eliminar = ref()
    let vacio = ref()
    let repe = ref()
    let cambio = ref()
    let conex = ref()
    let invalid = ref()
 
    dialog_eliminar.value = false
    vacio.value = false
    repe.value = false
    cambio.value = false
    conex.value = false
    invalid.value = false

    const pattern = new RegExp('^[A-Z]+$', 'i');

    ////////////////////////////PASAR ID Y NAME
    const pasar=(id:any,name:any)=>{
        idd.value = id
        nombre.value = name

    }
    ///////////////////////////////LIMPIAR INPUT
    const limpiar=()=>{
        nombre.value=""
    }
    ////////////////////////////////FUNCION PARA MOSTRAR Y ESCONDER BOTONES

    const esconder_id=()=>{
        let btnn:any
        btnn = document.querySelector(".btn_id")
        btnn.style.display="none" 
    }

    const esconder_mas=()=>{
        let btn:any
        btn = document.querySelector(".btn_mas")
        btn.style.display="none" 
    }

    const mostrar_mas=()=>{
        let btn:any
        btn = document.querySelector(".btn_mas")
        btn.style.display="block" 
    }
    const esconder_guardar=()=>{
        let btn:any
        btn = document.querySelector(".btn_editar")
        btn.style.display="none"    
    }
    const mostrar_guardar=()=>{
        let btn:any
        btn = document.querySelector(".btn_editar")
        btn.style.display="block"    
    }
    onMounted(()=>{
        esconder_id()
        esconder_guardar()
        
    })
    
    ////////////////////////////////////////////////////////////////////FUNCION OBTENER 


    const obtener=()=>{

    axios.get("http://localhost:8888/damedatos/")
    .then((response)=>{
        let r = response.data   
        
        if(r.status=="OK"){
        console.log(r.message+" "+r.datos) 
        }
        dato.value = r.datos
    }).catch((error)=>{
        conex.value = true
        console.log(error)
        limpiar()
    })
    }
    obtener()

    //////////////////////////////////////////////////////////////////FUNCION REGISTRAR
    
    const registrar=()=>{
        
        let nom=ref()
        if(nombre.value==""){

            vacio.value = true
            return
        }
       
        if(!pattern.test(nombre.value)){ 
            invalid.value = true
            limpiar()
            return
        }

        dato.value.forEach((elem:any)=>{
            nom.value = elem.name

            if(nom.value.localeCompare(nombre.value,undefined,{sensitivity: 'base'})==0){
                
                repe.value = true
                limpiar()
                return
            }
        })
        if(nombre.value==""){

            return
        }
        
        const formData = new FormData();
        formData.append("name", nombre.value);

    axios.post("http://localhost:8888/insertar/",formData)
    .then((response)=>{
        let r = response.data   
        console.log(r)
        
        if(r.status=="OK"){
            console.log(r.message+" "+r.datos) 
        }
        dato.value = r.datos
        limpiar()
        obtener()
    }).catch((error)=>{
        conex.value = true
        console.log(error)
        limpiar()
    })
    }

    //////////////////////////////////////////////////////////////////////FUNCION ELIMINAR

    const eliminacion=(id:any,name:any)=>{
        eliminar_id.value = id
        eliminar_name = name
        dialog_eliminar.value = !dialog_eliminar.value
    }

    const eliminar=(id:any)=>{
        

        const formData = new FormData();

            formData.append("id",id );
    
            axios.post("http://localhost:8888/eliminar/",formData)
            .then((response)=>{
            let r = response.data   
            console.log(r)
            if(r.status=="OK"){
                console.log(r.message+" "+r.datos) 
            }
            dato.value = r.datos
            obtener()
            }).catch((error)=>{
                conex.value = true
                console.log(error)
                limpiar()
            })    
            }
    
    //////////////////////////////////////////////////////////////////////FUNCION EDITAR

    const editar=()=>{

        if(nombre.value==""){
            alert("Campo vacío..")
            return
        }
        dato.value.forEach((dat:any)=>{
            
            if(dat.name == nombre.value){
                cambio.value = true
                limpiar()
                return
            }
        })
        if(nombre.value==""){
            return
        }
        const formData = new FormData();
        formData.append("id",idd.value)
        formData.append("name",nombre.value)

        axios.post("http://localhost:8888/modificar/",formData)
        
        .then((response)=>{
        let r = response.data   
        console.log(r)
        if(r.status=="OK"){
            console.log(r.message+" "+r.datos) 
        }
        dato.value = r.datos
        
        obtener()
        }).catch((error)=>{
            conex.value = true
            console.log(error)
            limpiar()
        })
        limpiar()
        
        
    }
</script>
<!--/////////////////////////////////////////////////////////////////////////////HTML-->


<template>
    <v-container class="bg-light-blue-lighten-2 mt-2 rounded-lg">
    
        <!--//////////////////////////////////////TITULO-->   
        
        <v-row>
            <v-col>
                <h2 
                    class="text-4 display-2"
                    >REGISTRO DE ROLES
                </h2>
            </v-col>    
        </v-row>
        
        <br>
        <!--//////////////////////////////////////INPUT NOMBRE / ID-->

        <v-row 
            class="w-25"
            >

            <v-col 
                class="mt-n2 mb-1"
                >
                <input
                    class="elevation-10 pa-1 bg-white text-black rounded-lg"
                    v-model="nombre"     
                    >
                
                <input
                    v-model="idd" 
                    class="bg-white btn_id"
                    >
            </v-col>
            
        </v-row>
        <br>
        <!--///////////////////////////////SNACKBAR CAMPO VACIO-->
        <v-snackbar
            v-model="vacio"
            location="top"
            color="error"
            >
            {{ "Campo vacio.." }}

            <template v-slot:actions>
                <v-btn
                color="white"
                variant="text"
                
                @click="vacio = false"
                >
                Close
                </v-btn>
            </template>
        </v-snackbar>
        <!--///////////////////////////////SNACKBAR ROL REPETIDO-->
        <v-snackbar
            v-model="repe"
            location="top"
            color="error"
            >
            {{ "Rol repetido.." }}

            <template v-slot:actions>
                <v-btn
                color="white"
                variant="text"
                
                @click="repe = false"
                >
                Close
                </v-btn>
            </template>
        </v-snackbar>
        <!--///////////////////////////////SNACKBAR NO SE HIZO CAMBIOS-->
        <v-snackbar
            v-model="cambio"
            location="top"
            color="error"
            >
            {{ "No se hizo ningun cambio.." }}

            <template v-slot:actions>
                <v-btn
                color="white"
                variant="text"
                
                @click="cambio = false"
                >
                Close
                </v-btn>
            </template>
        </v-snackbar>
        <!--///////////////////////////////SNACKBAR DESEA ELIMINAR EL REGISTRO-->
        
        <v-snackbar
            v-model="dialog_eliminar"
            location="top"
            color="warning"
            >
            <v-card-text>Desea eliminar el registro{{eliminar_id}} {{eliminar_name}}</v-card-text>
            <template v-slot:actions>
                <v-btn
                    color="white"
                    variant="text"
                    
                    @click="dialog_eliminar = false"
                    >
                    Cancel
                </v-btn>
                <v-btn
                    color="white"
                    variant="text"
                    
                    @click="dialog_eliminar = eliminar(eliminar_id)"
                    >
                    Ok
                </v-btn>
            </template>

                </v-snackbar> 
                
                <!--///////////////////////////////SNACKBAR CAMPO INVALIDO--> 
                
                <v-snackbar
                    v-model="invalid"
                    location="top"
                    color="error"
                    >
                    {{ "Campo invalido.." }}

                    <template v-slot:actions>
                        <v-btn
                        color="white"
                        variant="text"
                        
                        @click="invalid = false"
                        >
                        Close
                        </v-btn>
                    </template>
                </v-snackbar>
                <!--///////////////////////////////SNACKBAR NO SE HIZO CAMBIOS-->
                <v-snackbar
                    v-model="conex"
                    location="top"
                    color="error"
                    >
                    {{ "Error en conexion AXIOS.." }}

                    <template v-slot:actions>
                        <v-btn
                        color="white"
                        variant="text"
                        
                        @click="conex = false"
                        >
                        Close
                        </v-btn>
                    </template>
                </v-snackbar>

        <!--/////////////////////////////BOTONES REGISTRAR Y GUARDAR EDICION-->
        <v-row>
            <v-col >
                <v-btn 
                    class="elevation-5 text-blue-grey-darken-4 bg-blue-grey-lighten-5 rounded-lg btn_mas" 
                    @click="registrar()"
                    >Añadir
                </v-btn>
                
                <v-btn 
                    class="elevation-5 text-blue-grey-darken-4 bg-blue-grey-lighten-5 rounded-lg btn_editar" 
                    @click="editar(), 
                    esconder_guardar(), 
                    mostrar_mas()"
                    >Guardar
                </v-btn>
                
            </v-col>
            
        </v-row>
       
        <br>

        <!--///////////////////////////////////////TABLA DE REGISTRO DE ROLES-->
        <v-row >
            <v-col cols="12">
                <v-table 
                    fixed-header  
                    class="elevation-10 py-4 table rounded-lg"
                    >
                    <!--///////////////////////////////COLUMNA ID Y NOMBRE-->
                    <thead>
                        <tr>
                            <th 
                                class="pa-2 pl-2 text-center text-blue-grey-darken-4"
                                >ID
                            </th>

                            <th 
                                class="text-blue-grey-darken-4"
                                >NOMBRE
                            </th>

                        </tr>

                    </thead>
                    <!--////////////////////////MOSTRAR REGISTROS DE ID Y NOMBRE-->
                    <tbody>
                        <tr v-for="dat in dato" :key="dat.id">
                            
                            <td 
                                class="pa-2 pl-2 text-center"
                                >{{ dat.id }}
                            </td>
                            <td 
                                class="pa-2 pl-4 "
                                >{{ dat.name }}
                            </td>
                            <!--//////////////////////////////////BOTON ELIMINAR-->
                            <v-btn 
                                class="elevation-5 bg-red-darken-1 rounded-lg mr-2 btn_editar" 
                                @click="eliminacion(dat.id,dat.name)"
                                >Eliminar
                            </v-btn>
                            <!--///////////////////////////////////BOTON EDITAR-->
                            <v-btn 
                                class="elevation-5 bg-green-accent-4 rounded-lg btn_editar" 
                                @click="pasar(dat.id,dat.name),
                                mostrar_guardar(),
                                esconder_mas()"
                                >Editar
                            </v-btn>
                        </tr>
                    </tbody>
            </v-table>
            

            
            </v-col>
            <div class="text-center ma-2">
    
    
  </div>
        </v-row>
        
    </v-container>    
    
</template>

<style scoped>

    
</style>