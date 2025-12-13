<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 flex flex-col">
    <NavigationBar />

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary-600 to-indigo-600 py-20">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold text-white mb-4">PDF Merger Blog</h1>
        <p class="text-xl text-primary-100 max-w-2xl mx-auto">
          Insights, tips, and best practices for working smarter with PDFs
        </p>
      </div>
    </section>

    <!-- Featured Slider -->
    <section class="container mx-auto px-4 py-16">
      <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">
          Featured Articles
        </h2>

        <div class="relative h-[420px]">
          <!-- Slide -->
          <article
            v-for="(post, index) in featuredPosts"
            :key="post.id"
            class="absolute inset-0 w-full max-w-lg mx-auto transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)]"
            :class="index === activeFeatured ? 'translate-x-0 scale-100 z-50' : index < activeFeatured ? '-translate-x-24 scale-[0.85] z-40 opacity-70' : 'translate-x-24 scale-[0.85] z-30 opacity-70'"
          >
            <label class="absolute inset-0 cursor-pointer" @click="setActiveFeatured(index)">
              <span class="sr-only">Open blog post {{ post.title }}</span>
            </label>
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl h-full flex flex-col">
              <header class="mb-4">
                <div class="inline-flex items-center gap-2 mb-4">
                  <span
                    class="px-3 py-1 rounded-full bg-gradient-to-r from-primary-100 to-indigo-100 dark:from-primary-900/30 dark:to-indigo-900/30 text-primary-700 dark:text-primary-300 text-xs font-medium"
                  >
                    {{ post.tag }}
                  </span>
                  <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ post.readTime }} min read
                  </span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                  {{ post.title }}
                </h3>
              </header>

              <p class="text-gray-600 dark:text-gray-400 mb-6 line-clamp-4">
                {{ post.excerpt }}
              </p>

              <footer class="mt-auto flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                  <div
                    class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-indigo-500 flex items-center justify-center text-white font-bold"
                  >
                    {{ post.authorInitials }}
                  </div>
                  <div>
                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                      {{ post.author }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                      {{ post.role }}
                    </div>
                  </div>
                </div>
                <button
                  class="inline-flex justify-center whitespace-nowrap rounded-lg px-4 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors"
                >
                  Read more →
                </button>
              </footer>
            </div>
          </article>
        </div>

        <!-- Slider Dots -->
        <div class="flex justify-center gap-3 mt-10">
          <button
            v-for="(post, index) in featuredPosts"
            :key="post.id"
            @click="setActiveFeatured(index)"
            class="w-3 h-3 rounded-full transition-all duration-300"
            :class="activeFeatured === index ? 'bg-primary-600 w-8' : 'bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600'"
          />
        </div>
      </div>
    </section>

    <!-- All Posts Grid -->
    <section class="bg-white dark:bg-gray-900 py-16">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
          <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">All Articles</h2>
            <p class="text-gray-600 dark:text-gray-400">
              Explore our latest content about PDFs, productivity, and document security.
            </p>
          </div>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 max-w-6xl mx-auto">
          <CardComponent
            v-for="post in posts"
            :key="post.id"
            class="flex flex-col h-full border border-gray-100 dark:border-gray-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
          >
            <div class="p-6 flex flex-col h-full">
              <div class="flex items-center justify-between mb-4">
                <span
                  class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-primary-50 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300"
                >
                  {{ post.tag }}
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                  {{ post.date }}
                </span>
              </div>

              <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                {{ post.title }}
              </h3>

              <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                {{ post.excerpt }}
              </p>

              <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-2">
                  <div
                    class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-indigo-500 flex items-center justify-center text-white text-xs font-bold"
                  >
                    {{ post.authorInitials }}
                  </div>
                  <div>
                    <div class="text-xs font-medium text-gray-900 dark:text-white">
                      {{ post.author }}
                    </div>
                    <div class="text-[11px] text-gray-500 dark:text-gray-400">
                      {{ post.readTime }} min read
                    </div>
                  </div>
                </div>

                <button
                  class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300"
                >
                  Read more →
                </button>
              </div>
            </div>
          </CardComponent>
        </div>
      </div>
    </section>

    <FooterSection />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import NavigationBar from '../components/NavigationBar.vue'
import FooterSection from '../components/FooterSection.vue'
import CardComponent from '../components/CardComponent.vue'

const activeFeatured = ref(0)

const featuredPosts = ref([
  {
    id: 1,
    title: 'Advanced PDF Management Tips for Professionals',
    tag: 'Tutorial',
    readTime: 8,
    excerpt:
      'Learn how to structure your PDF workflow, batch process recurring tasks, and integrate PDF tools into your daily productivity stack.',
    author: 'John Doe',
    authorInitials: 'JD',
    role: 'PDF Expert'
  },
  {
    id: 2,
    title: 'How We Keep Your Documents Safe and Secure',
    tag: 'Security',
    readTime: 6,
    excerpt:
      'A deep dive into encryption standards, secure transport, and the privacy practices we follow to protect your documents.',
    author: 'Alex Smith',
    authorInitials: 'AS',
    role: 'Security Lead'
  },
  {
    id: 3,
    title: 'Streamline Your Document Workflow in 2024',
    tag: 'Productivity',
    readTime: 7,
    excerpt:
      'Discover the latest tools and strategies to simplify document management, collaborate with teams, and stay organized.',
    author: 'Maria Johnson',
    authorInitials: 'MJ',
    role: 'Product Manager'
  }
])

const posts = ref([
  {
    id: 4,
    title: '5 Common PDF Mistakes and How to Avoid Them',
    tag: 'Guides',
    date: 'Nov 18, 2024',
    readTime: 5,
    excerpt:
      'From oversized files to broken layouts, here are the most common PDF issues professionals run into—and how to fix them fast.',
    author: 'Emily Carter',
    authorInitials: 'EC'
  },
  {
    id: 5,
    title: 'Choosing the Right PDF Tools for Your Team',
    tag: 'Productivity',
    date: 'Oct 02, 2024',
    readTime: 9,
    excerpt:
      'Not all PDF tools are created equal. We break down what really matters when picking a solution for your organization.',
    author: 'Liam Nguyen',
    authorInitials: 'LN'
  },
  {
    id: 6,
    title: 'Understanding PDF Security in Simple Terms',
    tag: 'Security',
    date: 'Sep 14, 2024',
    readTime: 6,
    excerpt:
      'Encryption, SSL, access control—learn the basics of PDF security without getting lost in technical jargon.',
    author: 'Sophia Martinez',
    authorInitials: 'SM'
  },
  {
    id: 7,
    title: 'How to Prepare Documents for Flawless Merging',
    tag: 'Tutorial',
    date: 'Aug 30, 2024',
    readTime: 4,
    excerpt:
      'Simple steps you can take before merging to avoid page order issues, orientation problems, and layout glitches.',
    author: 'Daniel Kim',
    authorInitials: 'DK'
  },
  {
    id: 8,
    title: 'Remote Teams and PDF Workflows',
    tag: 'Remote Work',
    date: 'Aug 05, 2024',
    readTime: 7,
    excerpt:
      'Best practices for collaborating on documents when your team is spread across time zones and devices.',
    author: 'Olivia Brown',
    authorInitials: 'OB'
  },
  {
    id: 9,
    title: 'The Future of Document Automation',
    tag: 'Trends',
    date: 'Jul 12, 2024',
    readTime: 10,
    excerpt:
      'From AI-assisted editing to automated workflows, explore how document automation is changing modern work.',
    author: 'Noah Wilson',
    authorInitials: 'NW'
  }
])

function setActiveFeatured(index) {
  activeFeatured.value = index
}

onMounted(() => {
  activeFeatured.value = 0
})
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-4 {
  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>


