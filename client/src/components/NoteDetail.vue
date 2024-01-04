<template lang="">
    <div class="flex flex-col w-96 border-2 p-1">
        <h1 class="font-bold text-xl" v-if="!isEdit">{{props.title}}</h1>
        <input v-else type="text" v-model="dataUpdate.title">
        <span class="p-2" v-if="!isEdit">{{props.description}}</span>
        <textarea v-else v-model="dataUpdate.description"></textarea>
        <section class="flex">
            <button 
            class="m-auto w-1/4 bg-red-700 text-white font-bold rounded-md p-1 mb-2"
            @click="deleteNote"
            v-if="!isEdit"
            >
                Eliminar
            </button>
            <button 
                class="m-auto w-1/4 bg-green-700 text-white font-bold rounded-md p-1"
                @click="onEdit"
                v-if="!isEdit"
            >
                Editar
            </button>
        </section>
        <section class="flex">
            <button 
            class="m-auto w-1/4 bg-red-700 text-white font-bold rounded-md p-1 mb-2"
            @click="onEdit"
            v-if="isEdit"
        >
            Cancelar
        </button>
        <button 
            class="m-auto w-1/4 bg-blue-700 text-white font-bold rounded-md p-1"
            @click="updateNote"
            v-if="isEdit"
        >
            Guardar
        </button>
        </section>
    </div>
</template>

<script lang="ts">
    import { defineComponent, ref } from 'vue';
    
    export default defineComponent({
        name: "NoteDeatil",
        props: {
            id: Number,
            title: String,
            description: String
        },
        emits: ["delete", "update"],
        setup(props, {emit}) {
            
            let isEdit = ref(false)
            let dataUpdate = ref({
                id: props.id,
                title: props.title,
                description: props.description
            })
            
            function deleteNote(){
                emit("delete", props.id)
            }

            function updateNote(){
                emit("update", dataUpdate.value)
                isEdit.value = false
            }

            function onEdit(){
                isEdit.value = !isEdit.value
            }

            return{props, deleteNote, onEdit, dataUpdate, isEdit, updateNote}
        },
    })
</script>
