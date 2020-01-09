<template>
  <div>
    <div class="bg-white-op-90 py-30">
      <div class="content">
        <form @submit.prevent="setPrice">
          <div class="row">
            <div class="col-lg-6 col-md-12 py-20">
              <div class="form-group">
                <label class="col-12" for="example-email-input">Regular Price</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" v-model="form.price" />
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-12 py-20">
              <div class="form-group">
                <label class="col-12" for="example-email-input">Promo Price</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" v-model="form.promo_price" />
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary mb-10">Save Price</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      form: new Form({
        price: "",
        promo_price: ""
      })
    };
  },
  methods: {
    setPrice() {
      this.$store.dispatch("storeCoursePrice", {
        price: this.form.price,
        promo_price: this.form.promo_price
      });
    },
    getPrice() {
      let courseData = this.$store.getters.getAllData;
      this.form.price = courseData.price;
      this.form.promo_price = courseData.promo_price;
    }
  },
  mounted() {
    this.getPrice();
  }
};
</script>
