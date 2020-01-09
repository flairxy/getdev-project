<template>
    <div>
        <div class="bg-white-op-90 mt-60 py-30">
            <div class="content">
                <div v-if="fetchingCourse">fetching course....</div>
                <div v-else>
                    <h5 class="font-s16 font-w900 text-muted">
                        Category:
                        <span class="text-dark">{{ course.category }}</span>
                    </h5>
                    <hr />
                    <review-top
                        v-if="course.type == 1"
                        :premium="course.type"
                        :image="course.cover_image"
                        :courseTitle="course.title"
                        :courseAuthor="course.tutor"
                        :courseDescription="course.description"
                        :courseRating="course.rating"
                        :courseStudentNumber="course.students"
                        :courseAmount="course.price"
                        height="180"
                        width="320"
                        :enrolled="enrolled"
                        @myClick="pay(course.price)"
                    />
                    <review-top
                        v-else
                        :premium="course.type"
                        :image="course.cover_image"
                        :courseTitle="course.title"
                        :courseAuthor="course.tutor"
                        :courseDescription="course.description"
                        :courseRating="course.rating"
                        :courseStudentNumber="course.students"
                        :courseAmount="course.price"
                        height="180"
                        width="320"
                        :enrolled="enrolled"
                        @enroll="enroll(course.slug)"
                    />
                </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-lg-5 col-md-12 pull-right">
                        <h4 class="font-s22 font-w900 mb-5 text-center">
                            Course Content
                        </h4>
                        <div class="container">
                            <div class="col-md-12 col-lg-12 py-20">
                                <select
                                    class="form-control"
                                    @change="selectChapter"
                                    required
                                >
                                    <option value selected
                                        >Select chapter to view outline</option
                                    >
                                    <option
                                        v-for="chapter in chapters"
                                        :key="chapter"
                                        :value="chapter"
                                        >Chapter {{ chapter }}</option
                                    >
                                </select>
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <div
                                    class="bg-primary-lighter pl-10 py-5"
                                    v-for="(outline, index) in currentOutlines"
                                    :key="outline.id"
                                >
                                    <em
                                        class="text-primary fa fa-play-circle-o fa-2x"
                                    ></em
                                    >&nbsp;
                                    <span
                                        class="text-dark playerx xfont font-small font-w300 pointer"
                                        >Lesson {{ index + 1 }} -
                                        {{ outline.title.slice(0, 28) }}</span
                                    >
                                </div>
                                <!-- <ol style="padding-inline-start: 30px;">
                  <li v-for="outline in currentOutlines" :key="outline.id">
                    <span class="text-primary-light h6">{{ outline.title.slice(0,28) }}</span>
                  </li>
                </ol>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 pull-left">
                        <!-- <div class="col-lg-7 col-md-12"> -->
                        <div class="bg-gray-light mb-20">
                            <div class="container">
                                <div class="py-20">
                                    <h4 class="h5 text-muted mb-10">
                                        Student Reviews
                                    </h4>

                                    <student-review
                                        v-for="review in defaultReviews"
                                        :key="review.id"
                                        v-if="!showReviews"
                                        class="font-s16"
                                        :studentName="review.user"
                                        :courseRating="review.rating"
                                        :studentReview="review.body"
                                    />
                                    <div
                                        v-if="showReviews"
                                        style="height: 300px; overflow: auto;"
                                    >
                                        <student-review
                                            v-for="review in reviews"
                                            :key="review.id"
                                            class="font-s16"
                                            :studentName="review.user"
                                            :courseRating="review.rating"
                                            :studentReview="review.body"
                                        />
                                    </div>

                                    <a
                                        v-if="reviews.length > 3"
                                        href="#"
                                        @click.prevent="moreReviews"
                                    >
                                        <i
                                            v-if="!showReviews"
                                            class="text-primary fa fa-eye"
                                        ></i>
                                        <i
                                            v-if="showReviews"
                                            class="text-primary fa fa-eye-slash"
                                        ></i>
                                        {{
                                            showReviews
                                                ? `see less`
                                                : `see more`
                                        }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="modal-popinX"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modal-popin"
            style="display: none;"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-dialog-popin modal-dialog-centered"
                role="document"
            >
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-content text-center">
                            <QrcodeVue :value="value" :size="200" />
                            <br />
                            <span class="text-success h6"
                                >Send ${{ course.price }} to the wallet
                                address</span
                            >
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="example-input2-group1"
                                            id="address"
                                            :value="value"
                                            disabled
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <tutor-ad />
    </div>
</template>

<script>
import { RepositoryFactory as Repo } from "../../repository/RepositoryFactory";
const AR = Repo.get("academy");
export default {
    data() {
        return {
            enrolled: 0,
            showHidden: false,
            showReviews: false,
            fetchingCourse: true,
            currentChapter: "",
            course: {},
            currentOutlines: [],
            chapters: [],
            user: {},
            reviews: [],
            course_id: this.$route.params.id,
            courses: [],
            value: "",
            subscribed: false
        };
    },
    methods: {
        enroll(slug) {
            let values = {
                user: this.user.id,
                course: slug,
                enroll: "1"
            };
            AR.enroll(values)
                .then(res => {
                    toast.fire({
                        type: "success",
                        title: "Enrolled successfully"
                    });
                    location.reload();
                })
                .catch(err => {
                    toast.fire({
                        type: "error",
                        title: "Failed to enroll in course"
                    });
                });
        },
        getStudentCourses() {
            let slug = this.$route.params.slug;
            AR.loggedInUser().then(res => {
                this.user = res.data;
                let user = res.data.id;
                AR.checkSubscribers(user).then(resp => {
                    if (resp.data == 1) {
                        this.enrolled = 1;
                        AR.studentCourses(user).then(response => {
                            let courses = response.data.courses;
                            courses.map(course => {
                                if (course.slug == slug) {
                                    this.enrolled = 2;
                                }
                            });
                        });
                    }
                });
            });
        },
        pay(price) {
            let data = {
                user: this.user.id,
                amount: price
            };
            AR.buyCourse(data).then(res => {
                this.value = res.data;
                $("#modal-popinX").modal("show");
            });
        },
        selectChapter(event) {
            let id = event.target.value;
            this.currentChapter = id;
            this.currentOutline = {};
            let outlines = [];
            this.outlines.map(outline => {
                if (outline.chapter == id) {
                    outlines.push(outline);
                }
            });
            //   console.log(this.outlines);
            this.currentOutlines = outlines;
        },
        previewCourse(slug) {
            this.$router.push({
                name: "StudentCoursePreview",
                params: { slug: slug }
            });
        },
        seeMore() {
            this.showHidden = !this.showHidden;
        },
        moreReviews() {
            this.showReviews = !this.showReviews;
        },
        getTopRatedCourses() {
            AR.topRatedCourses().then(res => {
                this.courses = res.data;
            });
        },
        getCourse() {
            let slug = this.$route.params.slug;
            AR.studentCourse(slug).then(res => {
                this.course = res.data.course;
                let outlines = res.data.outlines;
                this.outlines = outlines;
                this.fetchingCourse = false;
                let chapters = [];
                outlines.map(outline => {
                    chapters.push(outline.chapter);
                });
                this.chapters = new Set(chapters);
            });
        },
        getReviews() {
            let slug = this.$route.params.slug;
            AR.getCourseReviews(slug).then(res => {
                this.reviews = res.data;
            });
        }
    },
    created() {
        // this.loadCourse();
        this.getCourse();
        this.getReviews();
        this.getStudentCourses();
        this.getTopRatedCourses();
        AR.loggedInUser().then(res => {
            this.user = res.data;
        });
    },
    computed: {
        defaultReviews() {
            let updatedReviews = [];
            let reviewIds = [];
            let reviews = this.reviews;
            this.reviews.filter(review => {
                for (let i = 1; i <= 3; i++) {
                    // check if the review id is already contained
                    let check = reviewIds.includes(review.id);
                    if (!check) {
                        updatedReviews.push(review);
                        reviewIds.push(review.id);
                    }
                }
            });
            return updatedReviews;
        }
    }
};
</script>
