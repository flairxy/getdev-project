<template>
  <div>
    <div class="bg-white-op-90 py-30">
      <div class="content block-content block-content-full">
        <div>
          <h5
            class="text-danger text-center font-italic font-size-sm"
          >Select or drop Your Video files according to the chapter and onlines</h5>
          <div class="form-group">
            <!-- <label class="col-12" for="example-email-input">Course haper</label> -->
            <div class="col-md-12 col-lg-6">
              <select class="form-control" @change="selectChapter" required>
                <option value selected>Select Chapter to uplad videos</option>
                <option
                  v-for="chapter in chapters"
                  :key="chapter"
                  :value="chapter"
                >Chapter {{ chapter }}</option>
              </select>
            </div>
          </div>
          <div class="mb-20" v-if="chapter_id">
            <div class="mb-10">
              <h4 class="text-primary">Chapter {{ chapter_id }}</h4>
            </div>
            <ol>
              <li v-for="outline in outlines" :key="outline.id">
                <div class="row mb-10">
                  <div class="col-lg-12">
                    <form enctype="multipart/form-data" @submit.prevent="onUpload(chapter_id)">
                      <div class="row">
                        <div class="col-md-12 col-lg-8 mb-10">
                          <label class="text-primary-light" for>{{ outline.title }}</label>
                          <span
                            v-for="video in videos"
                            :key="video.id"
                            v-if="video.outline_id == outline.id"
                          >
                            <i class="text-success fa fa-check"></i>
                          </span>
                          <b-form-file
                            @change="onfileChange(outline.id)"
                            :ref="'files' + outline.id"
                            accept=".mp4, .flv, .webm"
                          >
                            <template slot="file-name" slot-scope="{ names }">
                              <b-badge variant="dark">{{ names[0] }}</b-badge>
                              <b-badge
                                v-if="names.length > 1"
                                variant="dark"
                                class="ml-1"
                              >+ {{ names.length - 1 }} More files</b-badge>
                            </template>
                          </b-form-file>
                        </div>
                        <div class="col-lg-4 ac-py-27">
                          <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                          >{{ processing && currentOutline == outline.id ? `Uploading...` : `Upload Videos` }}</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { RepositoryFactory as Repo } from "../../../../repository/RepositoryFactory";
const AR = Repo.get("academy");

export default {
  props: ["course_id"],
  data() {
    return {
      file: "",
      chapter_id: "",
      outline_id: "",
      processing: false,
      currentOutline: "",
      outlines: [],
      videos: [],
      //   chapters: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','1'],
      chapters: [],
      form: new Form({
        price: "",
        promo_price: ""
      })
    };
  },
  methods: {
    selectChapter(event) {
      let id = event.target.value;
      this.chapter_id = id;
      let course_id = this.$props.course_id;
      //   let course_id = "cc4e6ea0-2628-11ea-855e-d33c27e50bdd";
      //   let course = this.$props.course_id;
      //get outline by course and chapter
      AR.getOutlinesByChapter(course_id, id).then(res => {
        let outlines = res.data;
        this.outlines = outlines;
        let courseOutlines = [];
        outlines.map(outline => {
          courseOutlines.push(outline.id);
        });
        let data = {
          outlines: courseOutlines
        };

        AR.getVideosByOutlines(data).then(res => {
          this.videos = res.data;
        });
      });
    },
    onfileChange(outline) {
      let myFile = "files" + outline;
      let uploadedFile = this.$refs[myFile][0].$refs.input.files[0];
      this.file = uploadedFile;
      this.outline_id = outline;
      //   let myFile = "files" + outline;
      //   let uploadedFiles = this.$refs[myFile][0].$refs.input.files;
      //   this.files.push(uploadedFiles[0]);
      //   let files = [];
      //   for (let i = 0; i < uploadedFiles.length; i++) {
      //     // this.files.push(uploadedFiles[i]);
      //     files.push({
      //       video: uploadedFiles[i],
      //       outline: outline
      //     });
      //   }
      //   console.log(files);
    },
    onUpload() {
      this.processing = true;
      this.currentOutline = this.outline_id;
      let course_id = this.$props.course_id;
      // let course_id = "0b85e350-2400-11ea-bf64-e91a11a10dd3";
      const formData = new FormData();
      //   for (let i = 0; i < this.files.length; i++) {
      //     let filename = this.files[i];
      //     formData.append("filename[" + i + "]", filename);
      //   }
      formData.append("filename", this.file);
      formData.append("chapter", this.chapter_id);
      formData.append("course_id", course_id);
      formData.append("outline_id", this.outline_id);
      AR.tutorUploadVideos(formData)
        .then(res => {
          Fire.$emit("refresh");
          this.processing = false;
          this.$forceUpdate();
          //reset uploaded files when done
          this.files = "";
          toast.fire({
            type: "success",
            title: "Video uploaded successfully"
          });
        })
        .catch(() => {
          toast({
            type: "warning",
            title: "Failed to upload videos"
          });
        });
    },
    loadChapters() {},
    loadOutlines() {
      let course = this.$props.course_id;
      AR.tutorCourseOutlines(course).then(res => {
        let outlines = res.data;
        let chapters = [];
        outlines.map(outline => {
          chapters.push(outline.chapter);
        });
        this.chapters = new Set(chapters);
      });
    }
  },
  created() {
    this.loadOutlines();
    Fire.$on("Refresh", () => {
      this.loadOutlines();
    });
  }
};
</script>

