<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useEditor, EditorContent, Editor } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Document from "@tiptap/extension-document";
import Paragraph from "@tiptap/extension-paragraph";
import Heading from "@tiptap/extension-heading";
import Text from "@tiptap/extension-text";
import Color from "@tiptap/extension-color";
import ListItem from "@tiptap/extension-list-item";
import TextStyle from "@tiptap/extension-text-style";
import { ref, onMounted, onBeforeUnmount } from "vue";

const editorSample1 = useEditor({
    content: "<p>I’m running Tiptap with Vue.js. 🎉</p> ",
    extensions: [Document, Paragraph, Text],
});

const editorSample2 = useEditor({
    content: "<p>Tiptap Editor that is editable</p>",
    extensions: [Document, Paragraph, Text],
    autofocus: true,
    editable: true,
    injectCSS: false,
});

const editor = ref(null);
onMounted(() => {
    editor.value = new Editor({
        extensions: [
            Color.configure({ types: [TextStyle.name, ListItem.name] }),
            TextStyle.configure({ types: [ListItem.name] }),
            StarterKit,
        ],
        content: `
        <h2>
          Hi there,
        </h2>
        <p>
          this is a <em>basic</em> example of <strong>Tiptap</strong>. Sure, there are all kind of basic text styles you’d probably expect from a text editor. But wait until you see the lists:
        </p>
        <ul>
          <li>
            That’s a bullet list with one …
          </li>
          <li>
            … or two list items.
          </li>
        </ul>
        <p>
          Isn’t that great? And all of that is editable. But wait, there’s more. Let’s try a code block:
        </p>
        <pre><code class="language-css">body {
  display: none;
}</code></pre>
        <p>
          I know, I know, this is impressive. It’s only the tip of the iceberg though. Give it a try and click a little bit around. Don’t forget to check the other examples too.
        </p>
        <blockquote>
          Wow, that’s amazing. Good work, boy! 👏
          <br />
          — Mom
        </blockquote>
      `,
    });
});

onBeforeUnmount(() => {
    editor.value.destroy();
});
</script>

<style lang="scss">
/* Basic editor styles */
.tiptap {
    :first-child {
        margin-top: 0;
    }

    /* List styles */
    ul,
    ol {
        padding: 0 1rem !important;
        margin: 1.25rem 1rem 1.25rem 0.4rem !important;

        li p {
            margin-top: 0.25em !important;
            margin-bottom: 0.25em !important;
        }
    }

    /* Heading styles */
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        line-height: 1.1;
        margin-top: 2.5rem;
        text-wrap: pretty;
    }

    h1,
    h2 {
        margin-top: 3.5rem;
        margin-bottom: 1.5rem;
    }

    h1 {
        font-size: 1.4rem;
    }

    h2 {
        font-size: 1.2rem;
    }

    h3 {
        font-size: 1.1rem;
    }

    h4,
    h5,
    h6 {
        font-size: 1rem;
    }

    /* Code and preformatted text styles */
    code {
        background-color: #dbd0db !important;
        border-radius: 0.4rem !important;
        color: var(--black) !important;
        font-size: 0.85rem !important;
        padding: 0.25em 0.3em !important;
    }

    pre {
        background-color: #2f302f !important;
        border-radius: 0.5rem !important;
        color: #f2f5f2 !important;
        font-family: "JetBrainsMono", monospace !important;
        margin: 1.5rem 0 !important;
        padding: 0.75rem 1rem !important;

        code {
            background: none !important;
            color: "inherit" !important;
            font-size: 0.8rem !important;
            padding: 0 !important;
        }
    }

    blockquote {
        border-left: 3px solid var(--gray-3) !important;
        margin: 1.5rem 0 !important;
        padding-left: 1rem !important;
    }

    hr {
        border: none !important;
        border-top: 1px solid var(--gray-2) !important;
        margin: 2rem 0 !important;
    }
}
</style>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-4"
                >
                    <!-- <div class="p-6 text-gray-900">You're logged inss!</div> -->
                    <editor-content :editor="editorSample1" />

                    <editor-content class="mt-[40px]" :editor="editorSample2" />

                    <div v-if="editor" class="container mt-[40px]">
                        <div class="control-group">
                            <div class="button-group">
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleBold()
                                            .run()
                                    "
                                    :disabled="
                                        !editor
                                            .can()
                                            .chain()
                                            .focus()
                                            .toggleBold()
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive('bold'),
                                    }"
                                >
                                    Bold
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleItalic()
                                            .run()
                                    "
                                    :disabled="
                                        !editor
                                            .can()
                                            .chain()
                                            .focus()
                                            .toggleItalic()
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive('italic'),
                                    }"
                                >
                                    Italic
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleStrike()
                                            .run()
                                    "
                                    :disabled="
                                        !editor
                                            .can()
                                            .chain()
                                            .focus()
                                            .toggleStrike()
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive('strike'),
                                    }"
                                >
                                    Strike
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleCode()
                                            .run()
                                    "
                                    :disabled="
                                        !editor
                                            .can()
                                            .chain()
                                            .focus()
                                            .toggleCode()
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive('code'),
                                    }"
                                >
                                    Code
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .unsetAllMarks()
                                            .run()
                                    "
                                >
                                    Clear marks
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .clearNodes()
                                            .run()
                                    "
                                >
                                    Clear nodes
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .setParagraph()
                                            .run()
                                    "
                                    :class="{
                                        'is-active':
                                            editor.isActive('paragraph'),
                                    }"
                                >
                                    Paragraph
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleHeading({ level: 1 })
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive(
                                            'heading',
                                            { level: 1 }
                                        ),
                                    }"
                                >
                                    H1
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleHeading({ level: 2 })
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive(
                                            'heading',
                                            { level: 2 }
                                        ),
                                    }"
                                >
                                    H2
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleHeading({ level: 3 })
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive(
                                            'heading',
                                            { level: 3 }
                                        ),
                                    }"
                                >
                                    H3
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleHeading({ level: 4 })
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive(
                                            'heading',
                                            { level: 4 }
                                        ),
                                    }"
                                >
                                    H4
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleHeading({ level: 5 })
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive(
                                            'heading',
                                            { level: 5 }
                                        ),
                                    }"
                                >
                                    H5
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleHeading({ level: 6 })
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive(
                                            'heading',
                                            { level: 6 }
                                        ),
                                    }"
                                >
                                    H6
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleBulletList()
                                            .run()
                                    "
                                    :class="{
                                        'is-active':
                                            editor.isActive('bulletList'),
                                    }"
                                >
                                    Bullet list
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleOrderedList()
                                            .run()
                                    "
                                    :class="{
                                        'is-active':
                                            editor.isActive('orderedList'),
                                    }"
                                >
                                    Ordered list
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleCodeBlock()
                                            .run()
                                    "
                                    :class="{
                                        'is-active':
                                            editor.isActive('codeBlock'),
                                    }"
                                >
                                    Code block
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .toggleBlockquote()
                                            .run()
                                    "
                                    :class="{
                                        'is-active':
                                            editor.isActive('blockquote'),
                                    }"
                                >
                                    Blockquote
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .setHorizontalRule()
                                            .run()
                                    "
                                >
                                    Horizontal rule
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .setHardBreak()
                                            .run()
                                    "
                                >
                                    Hard break
                                </button>
                                <button
                                    @click="editor.chain().focus().undo().run()"
                                    :disabled="
                                        !editor
                                            .can()
                                            .chain()
                                            .focus()
                                            .undo()
                                            .run()
                                    "
                                >
                                    Undo
                                </button>
                                <button
                                    @click="editor.chain().focus().redo().run()"
                                    :disabled="
                                        !editor
                                            .can()
                                            .chain()
                                            .focus()
                                            .redo()
                                            .run()
                                    "
                                >
                                    Redo
                                </button>
                                <button
                                    @click="
                                        editor
                                            .chain()
                                            .focus()
                                            .setColor('#958DF1')
                                            .run()
                                    "
                                    :class="{
                                        'is-active': editor.isActive(
                                            'textStyle',
                                            { color: '#958DF1' }
                                        ),
                                    }"
                                >
                                    Purple
                                </button>
                            </div>
                        </div>
                        <editor-content :editor="editor" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
