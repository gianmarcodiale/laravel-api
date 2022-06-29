<template>
    <div>
        <banner-component></banner-component>
        <div class="container-fluid">
            <div class="row">
                <main class="col-12 col-md-9 col-lg-10">
                    <section class="posts pt-4">
                        <div class="container">
                            <div
                                class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4"
                            >
                                <div
                                    class="col"
                                    v-for="post in postsResponse.data"
                                    :key="post.id"
                                >
                                    <div class="product card">
                                        <img
                                            :src="
                                                '/storage/' + post.cover_image
                                            "
                                            :alt="post.title"
                                        />
                                        <div class="card-body">
                                            <h3>{{ post.title }}</h3>
                                            <p>{{ trimText(post.content) }}</p>
                                            <a href="">Read more</a>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col">
                                                    <div
                                                        class="author"
                                                        v-if="post.user"
                                                    >
                                                        <h4>Author:</h4>
                                                        <small>{{
                                                            post.user.name
                                                        }}</small>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <span v-if="post.category"
                                                        ><strong
                                                            >Category: </strong
                                                        >{{
                                                            post.category.name
                                                        }}</span
                                                    >
                                                    <div
                                                        class="tags"
                                                        v-if="
                                                            post.tags.length > 0
                                                        "
                                                    >
                                                        <ul
                                                            class="list-unstyled"
                                                        >
                                                            <li
                                                                v-for="tag in post.tags"
                                                                :key="tag.id"
                                                            >
                                                                #{{ tag.name }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4">
                                <nav aria-label="Page navigation">
                                    <ul
                                        class="pagination justify-content-center"
                                    >
                                        <li
                                            class="page-item"
                                            v-if="
                                                postsResponse.current_page > 1
                                            "
                                        >
                                            <a
                                                class="page-link"
                                                href="#"
                                                aria-label="Previous"
                                                @click.prevent="
                                                    getAllPosts(
                                                        postsResponse.current_page -
                                                            1
                                                    )
                                                "
                                            >
                                                <span aria-hidden="true"
                                                    >&laquo;</span
                                                >
                                                <span class="sr-only"
                                                    >Previous</span
                                                >
                                            </a>
                                        </li>
                                        <li
                                            :class="{
                                                'page-item': true,
                                                active:
                                                    page ==
                                                    postsResponse.current_page,
                                            }"
                                            v-for="page in postsResponse.last_page"
                                            :key="page"
                                        >
                                            <a
                                                class="page-link"
                                                href="#"
                                                @click.prevent="
                                                    getAllPosts(page)
                                                "
                                                >{{ page }}</a
                                            >
                                        </li>
                                        <li
                                            class="page-item"
                                            v-if="
                                                postsResponse.current_page <
                                                postsResponse.last_page
                                            "
                                        >
                                            <a
                                                class="page-link"
                                                href="#"
                                                aria-label="Next"
                                                @click.prevent="
                                                    getAllPosts(
                                                        postsResponse.current_page +
                                                            1
                                                    )
                                                "
                                            >
                                                <span aria-hidden="true"
                                                    >&raquo;</span
                                                >
                                                <span class="sr-only"
                                                    >Next</span
                                                >
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </section>
                </main>
                <aside class="bg-white pt-4 col-12 col-md-3 col-lg-2">
                    <h4>Categories</h4>
                    <div class="categories widget">
                        <ul>
                            <li
                                v-for="category in categories"
                                :key="category.id"
                            >
                                {{ category.name }}
                            </li>
                        </ul>
                    </div>
                    <h4>Tags</h4>
                    <div class="widget tags">
                        <ul class="list-unstyled">
                            <li
                                v-for="tag in tags"
                                :key="tag.id"
                            >
                                #{{ tag.name }}
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</template>

<script>
import BannerComponent from "../components/BannerComponent.vue";
export default {
    name: "App",
    components: { BannerComponent },
    data() {
        return {
            categories: "",
            postsResponse: "",
            tags: "",
        };
    },
    methods: {
        getAllPosts(postPage) {
            axios
                .get("/api/posts", {
                    params: {
                        page: postPage, // Insert a param to take the list of posts for every page
                    },
                })
                .then((response) => {
                    // console.log(response);
                    // this.posts = response.data.data;
                    this.postsResponse = response.data;
                })
                .catch((e) => {
                    console.error(e);
                });
        },
        getAllCategories() {
            axios
                .get("/api/categories")
                .then((response) => {
                    console.log(response);
                    this.categories = response.data;
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        getAllTags() {
            axios
                .get("/api/tags")
                .then((response) => {
                    console.log(response);
                    this.tags = response.data;
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        trimText(text) {
            if (text.length > 100) {
                return text.slice(0, 100) + '...'
            }
            return text;
        }
    },
    mounted() {
        console.log("mounted");
        this.getAllPosts(1);
        this.getAllCategories();
        this.getAllTags();
    },
};
</script>

<style lang="scss" scoped>
aside {
    .widget {
        margin-bottom: 1rem;
        padding: 0.5rem;
        border-radius: 1rem;
        background-color: rgb(232, 231, 231);
    }
}
</style>
