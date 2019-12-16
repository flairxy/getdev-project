<template>
    <div>
        <student-header />

        <div class="py-30">
            <div class="content">
                <p class="font-s16 font-w700 text-dark pl-15">
                    Latest Messages
                </p>
                <div class="ac-card">
                    <div class="col-md-6 col-xl-3" v-for="index in 6">
                        <a
                            class="block block-link-shadow"
                            href="javascript:void(0)"
                        >
                            <div
                                class="block-content block-content-full clearfix"
                            >
                                <div class="text-left float-right mt-10">
                                    <div class="font-w600 mb-5">
                                        Jack Greene
                                    </div>
                                    <div class="font-size-sm text-muted">
                                        student
                                    </div>
                                </div>
                                <div class="float-left">
                                    <img
                                        class="img-avatar"
                                        :src="userImage"
                                        alt
                                    />
                                </div>
                            </div>
                            <div class="block-content bg-body-light">
                                <span class="font-size-sm">
                                    {{ message.slice(0, 80) }}
                                    <span class="text-primary"
                                        >...read more</span
                                    >
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message:
                "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorum vel aliquam, facere qui facilis dignissimos quisquam necessitatibus.",
            image1: "/images/ltutor.png",
            userImage: "/images/bg.jpg",
            image2: "/images/bg.jpg",
            courses: [
                {
                    image: "/images/luser1.png",
                    author: "Nicholas Cage",
                    amount: "9.99",
                    duration: "4:24:00",
                    title: "How to be the perfect player",
                    studentNUmber: "253,000",
                    image: "/images/bg.jpg",
                    rating: 5,
                    totalLesson: "18",
                    now: 22,
                    id: "22",
                    slug: "become-the-perfect-assasin",
                    description:
                        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium nostrum accusamus, blanditiis libero facere."
                },

                {
                    image: "/images/luser1.png",
                    author: "Rachel Okorie",
                    amount: "9.99",
                    duration: "4:24:00",
                    title: "Public Speaking Masterclass",
                    studentNUmber: "23,000",
                    image: "/images/bg.jpg",
                    rating: 5,
                    totalLesson: "18",
                    now: 45,
                    id: "17",
                    slug: "public-speaking-masterclass",
                    description:
                        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium nostrum accusamus, blanditiis libero facere."
                },

                {
                    image: "/images/luser1.png",
                    author: "Jane Doe",
                    amount: "19.79",
                    duration: "7:24:00",
                    title: "Vuejs 2.0 - The ultimate Vue Guide",
                    studentNUmber: "43,000",
                    image: "/images/bg.jpg",
                    rating: 4,
                    totalLesson: "23",
                    now: 82,
                    id: "12",
                    slug: "ultimate-vue-guide",
                    description:
                        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium nostrum accusamus, blanditiis libero facere quisquam."
                }
            ]
        };
    },
    methods: {
        previewCourse(slug) {
            this.$router.push({
                name: "StudentCoursePreview",
                params: { slug: slug }
            });
        },
        playCourse(id, slug) {
            this.$router.push({
                name: "StudentVideoCourse",
                params: { id: id, slug: slug }
            });
        }
    }
};
</script>
