<x-layout header="POSTS"> 
    <div id="posts">
        {{$posts}}
    </div>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            axios.get('/api/posts')
                .then(function (response) {

                    const posts = response?.data?.data; 
                    console.log(posts,posts?.posts,"============");
                    let postsHtml = '';

                    if(posts?.posts?.length ==0){
                        postsHtml += `<span>Sorry, No posts found</span>`;

                    }else{
                        posts?.posts?.forEach(post => {
                            postsHtml += `<p>${post.title}</p>`;
                        });
                    }
                    console.log(postsHtml);
                    document.getElementById('posts').innerHTML = postsHtml;
                })
                .catch(function (error) {
                    console.error('There was an error making the request:', error);
                });
        });
    </script> --}}
</x-layout>

