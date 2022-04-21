<template>
    <div class="row">
        <div class="col-12 mb-2 text-end">
            <router-link :to='{name:"taskCreate"}' class="btn btn-primary">Add New Task</router-link>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>All Tasks</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="task in tasks" :key="task.id">
                                    <td>ssdfkljaslk</td>
                                    <td>{{ task.title }}</td>
                                    <td>{{ task.description }}</td>
                                    <td>
                                        <router-link :to='{name:"taskEdit",params:{id:task.id}}' class="btn btn-success">Edit</router-link>
                                        <button type="button" @click="deleteTask(task.id)" class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody >
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            tasks:[]
        }
    },
    methods:{
        getTasks(){
            axios.get('/api/tasks')
            .then(({data}) => (this.tasks = data))
            .catch()
        },
        deleteCategory(id){
            if(confirm("Are you sure to delete this category ?")){
                this.axios.delete(`/api/tasks/${id}`).then(response=>{
                    this.getTasks()
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    },
     created(){
        this.getTasks();
    }
}
</script>