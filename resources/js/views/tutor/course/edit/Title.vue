<template>
  <div>
    <div class="bg-white-op-90 py-30">
      <div class="content">
        <div class="row">
          <div class="col-lg-6 col-md-12 py-20">
            <div class="form-group">
              <label class="col-12" for="example-email-input">Course Category</label>
              <div class="col-md-9">
                <select class="form-control" v-model="form.category_id" required>
                  <option value selected>Select Category</option>
                  <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                  >{{ category.name }}</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 py-20">
            <div class="form-group">
              <label class="col-12" for="example-email-input">Course Type</label>
              <div class="col-md-12">
                <select class="form-control" v-model="form.type" required>
                  <option value="#" disabled selected>Select Type</option>
                  <option value="0">Free</option>
                  <option value="1">Premium</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-12 py-20">
            <div class="form-group">
              <label class="col-12" for="example-email-input">Course Title</label>
              <div class="col-md-9">
                <input type="text" class="form-control" v-model="form.title" required />
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-12 py-20">
            <div class="form-group">
              <label class="col-12" for="example-email-input">Total chapters</label>
              <div class="col-md-9">
                <input type="number" class="form-control" v-model="form.total_chapters" required />
              </div>
            </div>
          </div>
        </div>
        <div class="container row">
          <div class="col-lg-6 col-md-12 py-20">
            <div class="form-group">
              <button type="submit" @click.prevent="submitTitle" class="btn btn-outline-primary">
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
import { RepositoryFactory as Repo } from "../../../../repository/RepositoryFactory";
const AR = Repo.get("academy");
// AR for AcademyRepository
export default {
  data() {
    return {
      categories: [],
      user: "",
      form: new Form({
        title: "",
        total_chapters: "",
        category_id: "",
        type: ""
      })
    };
  },
  methods: {
    submitTitle() {
      let data = {
        title: this.form.title,
        total_chapters: this.form.total_chapters,
        category_id: this.form.category_id,
        type: this.form.type
      };
      //   console.log(data);
      this.$store.dispatch("storeUser", this.user.id);
      this.$store.dispatch("storeCourseData", {
        title: data.title,
        total_chapters: data.total_chapters,
        category_id: data.category_id,
        type: data.type
      });
      toast.fire({
        type: "success",
        title: "Saved! continue"
      });
    },
    getCourse() {
      let id = this.$route.params.course;
      AR.getCourseById(id)
        .then(res => {
          let course = res.data.course;
          (this.form.title = course.title),
            (this.form.total_chapters = course.total_chapters),
            (this.form.category_id = course.category_id);
          this.form.type = course.type;
          this.$store.dispatch("storeCourseData", {
            title: course.title,
            total_chapters: course.total_chapters,
            category_id: course.category_id,
            type: course.type
          });
          this.$store.dispatch("storeCourseImage", course.cover_image);
          this.$store.dispatch("storeCourse", id);
          this.$store.dispatch("storeCoursePrice", {
            price: course.price,
            promo_price: course.promo_price
          });
          let outlines = res.data.outlines;
          outlines.map(outline => {
            this.$store.dispatch("storeNewOutline", {
              title: outline.title,
              chapter: outline.chapter,
              id: outline.id
            });
          });
        })
        .catch(err => {});
    }
  },
  mounted() {
    AR.loadCategories().then(res => {
      this.categories = res.data;
    });

    this.getCourse();

    AR.loggedInUser().then(res => {
      this.user = res.data;
    });
  }
};
</script>
