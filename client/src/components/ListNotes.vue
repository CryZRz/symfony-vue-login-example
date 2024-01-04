<template lang="">
    <section>
        <h1>Crear Nota</h1>
        <form action="" class="w-96 mb-3 mx-auto">
            <input
                class="w-full border-2 rounded-md p-1 mb-2 outline-none" 
                type="text" 
                placeholder="Titulo" 
                v-model="dataNewNote.title"
            >
            <textarea 
                placeholder="Descripcion" 
                v-model="dataNewNote.description"
                class="w-full border-2 rounded-md p-1 outline-none"
            ></textarea>
            <button 
                class="bg-blue-600 text-white font-bold w-full p-0.5 rounded-md" 
                @click="sendCreate"
            >
                Crear nota
            </button>
        </form>
    </section>
    <section class="w-full flex items-center justify-center gap-3">
        <NoteDetail 
            v-for="note in notes" 
            :key="note.id"
            :title="note.title"
            :description="note.description"
            :id="note.id"
            @delete="sendDelete"
            @update="sendUpdate"
        />
    </section>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from 'vue';
import NoteDetail from './NoteDetail.vue';
import NoteService from '@/services/NoteService' 
import NoteI from '@/Interfaces/NoteI';

export default defineComponent({
    name: "ListNotes",
    setup() {
        const noteService = new NoteService()
        const notes = noteService.getNotes()

        let dataNewNote = ref({
            id: 0,
            title: "",
            description: ""
        })

        onMounted(async() => {
            try {
                await noteService.fetchAll()
                console.log(notes.value)
            } catch (e) {
                console.log(e)
            }
        })

        async function sendCreate(e: SubmitEvent){
            e.preventDefault()
            try {
                await noteService.create(dataNewNote.value)
            } catch (e) {
                console.log(e)
            }
        }

        async function sendDelete(id: number) {
            try {
                await noteService.remove(id)
            } catch (e) {
                console.log(e)
            }
        }

        async function sendUpdate(note: NoteI) {
            try {
                await noteService.update(note)
            } catch (e) {
                console.log(e)
            }
        }

        return {notes, dataNewNote, sendCreate, sendDelete, sendUpdate}
    },
    components: {
        NoteDetail
    }
})
</script>

<style lang="">
    
</style>