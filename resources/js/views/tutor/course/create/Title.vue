<template>
    <div>
        <div class="bg-white-op-90 py-30">
            <div class="content">
                <div class="row">
                    <div class="col-lg-6 col-md-12 py-20">
                        <div class="form-group">
                            <label class="col-12" for="example-email-input"
                                >Course Category</label
                            >
                            <div class="col-md-9">
                                <select
                                    class="form-control"
                                    name="form.category"
                                >
                                    <option value="0">Please select</option>
                                    <option value="1">Option #1</option>
                                    <option value="2">Option #2</option>
                                    <option value="3">Option #3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 py-20">
                        <div class="form-group">
                            <label class="col-12" for="example-email-input"
                                >Course Title</label
                            >
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.title"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 py-20">
                        <div class="form-group">
                            <label class="col-12" for="example-email-input"
                                >Total chapters</label
                            >
                            <div class="col-md-9">
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="form.chapters"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container row">
                    <div class="col-lg-6 col-md-12 py-20">
                        <div class="form-group">
                            <button
                                type="submit"
                                @click.prevent="submitTitle"
                                class="btn btn-outline-primary"
                            >
                                <i class="fa fa-file"></i>
                                Save
                            </button>
                        </div>
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
            form: {
                title: "",
                chapters: ""
            }
        };
    },
    methods: {
        submitTitle() {
            let data = {
                title: this.form.title,
                chapters: this.form.chapters
            };
            this.$store.dispatch("storeCourseData", {
                title: data.title,
                chapters: data.chapters
            });
            toast.fire({
                type: "success",
                title: "Saved! continue"
            });
        }
    }
};
</script>
