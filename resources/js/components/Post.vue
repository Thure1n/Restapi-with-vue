<template>
    <div class="container" style="max-width:inherit">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="my-2" v-if="this.edit">Edit Post</h2>
                <h2 class="my-2" v-else>Create New Post</h2>
                <form v-on:submit.prevent="createPost" class="form-horizontal my-3">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Post Title" v-model="post.title">
                        <textarea class="form-control" rows="5" v-model="post.description"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Submit" class="btn btm-sm btn-primary">
                        <input v-if="this.edit==true" type="button" value="Cancel" @click="cancelEdit" class="btn btn-sm btn-secondary p-2">
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <h2 class="pt-3">Posts</h2>
                 <ul class="pagination">
                     <li v-bind:class="[{ disabled:!pagination.prev_page_url }]" class="page-item">
                         <a href="#"  class="page-link" @click="fetchPosts(pagination.prev_page_url)">Previous</a>
                    </li>
                    <li class="page-item disabled">
                         <a href="#" class="page-link text-dark ">Page {{ pagination.current_page }} of {{ pagination.last_page }} </a>
                    </li>
                    <li v-bind:class="[{ disabled:!pagination.next_page_url }]" class="page-item">
                         <a href="#" class="page-link" @click="fetchPosts(pagination.next_page_url)">Next</a>
                    </li>
                 </ul>
                <div class="card card-body mb-2"
                    v-for="post in posts" :key="post.id">
                    <h3>
                        {{ post.title }}
                    </h3>
                    <p class="pl-5">
                        {{ post.description }}
                    </p>
                    <div  v-if="current_user_id == post.user_id" class="d-flex justify-content-end">
                        <button class="btn btn-sm btn-warning mr-1" style="max-width:10%;"
                                @click="editPost(post)">
                             Edit
                        </button>
                        <button class="btn btn-sm btn-danger" style="max-width:10%;"
                                @click="deletePost(post.id)">
                             Delete
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    props:['auth_user_id'],
    data(){
        return{
            posts:[],
            post:{
                id:'',
                user_id:1,
                title:'',
                description:''
            },
            current_user_id:this.auth_user_id,
            post_id:'',
            pagination:{},
            edit:false,
        }
    },
    methods:{
        fetchPosts(page_url)
        {
            page_url = page_url || 'api/posts';
            fetch(page_url)
            .then(res=>res.json())
            .then(res=>{
                this.posts = res.posts.data;
                this.makePagination(res);
            })
            .catch(err=>console.log(err));
        },
        makePagination(res)
        {
            let pagination={
                prev_page_url : res.posts.prev_page_url,
                next_page_url : res.posts.next_page_url,
                current_page : res.posts.current_page,
                last_page : res.posts.last_page
            }
            this.pagination = pagination;
        },
        createPost()
        {
            if(this.edit === false)
            {
                //add new post
                fetch('api/post', {
                    method: 'post',
                    body: JSON.stringify(this.post),
                    headers:{
                        'content-type': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    alert('New post added');
                    this.post.title ='',
                    this.post.description =''
                    this.fetchPosts();
                })
                .catch(err => console.log(err));

            }
           else
           {
               //edit post
                fetch('api/post', {
                    method: 'put',
                    body: JSON.stringify(this.post),
                    headers:{
                        'content-type': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.edit =false;
                    alert('Post updated');
                    this.post.title ='',
                    this.post.description =''
                    this.fetchPosts();
                })
                .catch(err => console.log(err));

           }

        },
        deletePost(id)
        {
            if(confirm("Are you sure?This post will not get later!"))
            {
                fetch(`api/post/${id}`,{
                    method:'delete'
                })
            .then(res=>res.text())
                .then(data=>{
                    alert('Post was deleted');
                    this.fetchPosts();
                })
                .catch(err=>console.log(err));
            }
        },
        editPost(post)
        {
            this.edit = true;
            this.post.post_id = post.id,
            this.post.id = post.id,
            this.post.title = post.title,
            this.post.description = post.description
        },
        cancelEdit()
        {
            this.edit = false;
            this.post.title =  '',
            this.post.description = ''
        }


    },
    created:function(){
        this.fetchPosts();
        console.log(this.current_user_id);
    }
}
</script>
<style scoped>
    input,textarea{
        margin-bottom: 3%;
    }
</style>
