<template>
    <div>
        <div class="row">
            <div class="col-lg-4 col-md-12 text-center py-20">
                <thumbnail
                    :height="height"
                    :width="width"
                    :image="`/` + image"
                />
            </div>
            <div class="col-lg-6 col-md-12 py-20">
                <div>
                    <h4 class="font-s22 font-w900 mb-5">{{ courseTitle }}</h4>
                    <p class="font-s16 text-muted mb-3">
                        by
                        <span class="font-w700 text-dark">{{
                            courseAuthor
                        }}</span>
                    </p>
                </div>
                <p class="font-s16 mb-3 text-primary-light">
                    {{ courseDescription }}
                </p>

                <div class="row mb-3">
                    <div class="col-8 text-muted">
                        {{ courseStudentNumber }} Student(s)
                        <span class="js-rating">
                            <i
                                v-for="index in courseRating"
                                data-alt="2"
                                class="fa fa-fw fa-star text-warning"
                            ></i>
                            <i
                                v-for="index in 5 - courseRating"
                                data-alt="2"
                                class="fa fa-fw fa-star text-muted"
                            ></i>
                        </span>
                        {{ courseRating }}
                    </div>
                </div>
                <div class="container row">
                    <span
                        class="mr-2 text-muted font-s16 font-w400"
                        v-if="premium == 1"
                    >
                        <span v-if="enrolled == 0">
                            Buy: &nbsp;
                            <a
                                href="javascript:void(0)"
                                @click.prevent="handleClick"
                                class="btn btn-primary"
                                >{{ currency + courseAmount }}</a
                            >
                        </span>
                    </span>
                    <span class="mr-2 text-muted font-s16 font-w400" v-else>
                        <a
                            v-if="enrolled == 2"
                            href="javascript:void(0)"
                            class="btn bg-primary-lighter"
                            >Enrolled</a
                        >
                        <a
                            v-else-if="enrolled == 1"
                            href="javascript:void(0)"
                            @click="handleEnroll"
                            class="btn btn-primary"
                            >Enroll</a
                        >
                        <a
                            v-else
                            href="javascript:void(0)"
                            @click="handleSubscribe"
                            class="btn btn-primary"
                            >Subscribe Now</a
                        >
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// $route.params.slug = 'utlimate-vue-course',
export default {
    props: {
        image: String,
        courseTitle: String,
        courseAuthor: String,
        courseDescription: String,
        courseStudentNumber: String,
        courseRating: Number,
        courseAmount: String,
        height: String,
        width: String,
        premium: Number,
        enrolled: Number
    },
    data() {
        return {
            currency: this.$store.state.currency
        };
    },
    methods: {
        handleClick() {
            this.$emit("myClick");
        },
        handleEnroll() {
            this.$emit("enroll");
        },
        handleSubscribe() {
            window.location = "/subscribe";
        }
    }
};
</script>
