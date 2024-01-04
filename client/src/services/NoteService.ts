import NoteI from "@/Interfaces/NoteI";
import { clientAuthFetch } from "@/utils/clientFetch";
import { Ref, ref } from "vue";
import { useAuth } from "@/store/authContext";
import axios from "axios";

class NotesService {

    private notes: Ref<NoteI[]>
    private auth = useAuth()

    constructor(){
        this.notes = ref([])
    }

    getNotes(){
        return this.notes
    }

    async fetchAll(){
        try {
            const listNotes = await clientAuthFetch.get("/notes",{
                headers: {
                    Authorization: `Bearer ${this.auth.token}`
                }
            } 
            )
            console.log(listNotes.data.notes)
            this.notes.value = listNotes.data.notes
        } catch (e) {
            console.log(e)
            if(axios.isAxiosError(e)){
                throw new Error(e.message)
            }
        }
    }

    async fetchById(id: number){
        try {
            await clientAuthFetch.get(`/notes/${id}`,{
                headers: {
                    Authorization: `Bearer ${this.auth.token}`
                }
            })
        } catch (e) {
            if(axios.isAxiosError(e)){
                throw new Error(e.message)
            }
        }
    }

    async create(data: NoteI){
        try {
            const note = await clientAuthFetch.post("/notes", data, {
                headers: {
                    Authorization: `Bearer ${this.auth.token}`
                }
            })
            this.notes.value.unshift(note.data.note)
        } catch (e) {
            if(axios.isAxiosError(e)){
                throw new Error(e.message)
            }
        }
    }

    async update(data: NoteI){
        try {
            await clientAuthFetch.put(`/notes/${data.id}`, data, {
                headers: {
                    Authorization: `Bearer ${this.auth.token}`
                }
            })
            const noteEdit = this.notes.value.find(note => note.id == data.id)
            if(noteEdit){
                noteEdit.title = data.title
                noteEdit.description = data.description
            }
        } catch (e) {
            console.log(e)
            if(axios.isAxiosError(e)){
                throw new Error(e.message)
            }
        }
    }

    async remove(id: number){
        try {
            await clientAuthFetch.delete(`/notes/${id}`, {
                headers: {
                    Authorization: `Bearer ${this.auth.token}`
                }
            })
            const newListNotes = this.notes.value.filter(note => note.id != id)
            this.notes.value = newListNotes
        } catch (e) {
            if(axios.isAxiosError(e)){
                throw new Error(e.message)
            }
        }
    }
}

export default NotesService