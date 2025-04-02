<template>
  <div v-if="editor">
    <div class="menubar">
      <v-button
        @click.prevent="
          () =>
            editor
              .chain()
              .focus()
              .toggleBold()
              .run()
        "
        class="menubar-btn"
        :class="{ 'is-active': editor.isActive('bold') }"
        size="sm"
        :color="'light'"
        title="Полужирный"
      >
         <font-awesome-icon icon="bold" />
      </v-button>

      <v-button
        @click.prevent="
          () =>
            editor
              .chain()
              .focus()
              .toggleItalic()
              .run()
        "
        class="menubar-btn"
        :class="{ 'is-active': editor.isActive('italic') }"
        size="sm"
        :color="'light'"
        variant="link"
        title="Курсив"
      >
        <font-awesome-icon icon="italic" />
      </v-button>

      <v-button
        @click.prevent="toggleUnderline"
        class="menubar-btn"
        :class="{ 'is-active': editor.isActive('underline') }"
        size="sm"
        :color="'light'"
        variant="link"
        title="Подчеркнутый"
      >
        <font-awesome-icon icon="underline" />
      </v-button>

      <v-button
        @click.prevent="toggleStrike"
        class="menubar-btn"
        :class="{ 'is-active': editor.isActive('strike') }"
        size="sm"
        :color="'light'"
        variant="link"
        title="Зачеркнутый"
      >
        <font-awesome-icon icon="strikethrough" />
      </v-button>

      <v-dropdown-button :align="'left'" :btnClasses="'menubar-btn'" title="Таблица">
        <template #trigger>
            <font-awesome-icon icon="table" />
        </template>
        <template #content>
            <div class="flex flex-col">
                <span @click.prevent="insertTable" class="whitespace-nowrap py-0.5">Добавить таблицу</span>
                <span @click.prevent="deleteTable" class="whitespace-nowrap py-0.5">Удалить таблицу</span>
                
                <hr />
                
                <span @click.prevent="addColumnBefore" class="whitespace-nowrap py-0.5">Добавить колонку ДО</span>
                <span @click.prevent="addColumnAfter" class="whitespace-nowrap py-0.5">Добавить колонку ПОСЛЕ</span>
                <span @click.prevent="deleteColumn" class="whitespace-nowrap py-0.5">Удалить колонку</span>
            
                <hr />
                
                <span @click.prevent="addRowBefore" class="whitespace-nowrap py-0.5">Добавить строку ДО</span>
                <span @click.prevent="addRowAfter" class="whitespace-nowrap py-0.5">Добавить строку ПОСЛЕ</span>
                <span @click.prevent="deleteRow" class="whitespace-nowrap py-0.5">Удалить строку</span>

                <hr />

                <span @click.prevent="mergeOrSplit" class="whitespace-nowrap py-0.5">Объединить/разделить ячейки</span>
            </div>
            
        </template>
      </v-dropdown-button>

      <v-dropdown-button :align="'left'" :btnClasses="'menubar-btn'" title="Список">
        <template #trigger>
            <font-awesome-icon icon="list-ul" />
        </template>
        <template #content>
            <div class="flex flex-col">

                <span @click.prevent="toggleBulletList" class="whitespace-nowrap py-0.5" :class="{ 'is-active': editor.isActive('bulletList') }">
                    <font-awesome-icon icon="list-ul" /> Неупорядоченный список
                </span>

                <span @click.prevent="toggleOrderedList" class="whitespace-nowrap py-0.5" :class="{ 'is-active': editor.isActive('orderedList') }">
                    <font-awesome-icon icon="list-ol" /> Упорядоченный список
                </span>
            </div>
            
        </template>
      </v-dropdown-button>

      <v-button
        @click.prevent="editor.chain().focus().undo().run()"
        :disabled="!editor.can().undo()"
        class="menubar-btn"
        :class="{ 'is-active': editor.isActive('underline') }"
        size="sm"
        :color="'light'"
        variant="link"
        title="Отменить"
      >
        <font-awesome-icon icon="undo" />
      </v-button>

      <v-button
        @click.prevent="editor.chain().focus().redo().run()"
        :disabled="!editor.can().redo()"
        class="menubar-btn"
        :class="{ 'is-active': editor.isActive('underline') }"
        size="sm"
        :color="'light'"
        variant="link"
        title="Вернуть"
      >
        <font-awesome-icon icon="repeat" />
      </v-button>
    </div>

    <div @keydown.enter="ctrlEnter">
      <editor-content :editor="editor" />
    </div>

  </div>
</template>
  
<script>
    import { Editor, EditorContent } from '@tiptap/vue-3'

    import Document from "@tiptap/extension-document"
    import Paragraph from "@tiptap/extension-paragraph"
    import Text from "@tiptap/extension-text"
    import Placeholder from "@tiptap/extension-placeholder"
    //Базовые
    import Bold from "@tiptap/extension-bold"
    import Italic from "@tiptap/extension-italic"
    //Цвета
    import TextStyle from "@tiptap/extension-text-style"
    //Форматирование
    import Underline from "@tiptap/extension-underline"
    import Strike from "@tiptap/extension-strike"
    import Blockquote from "@tiptap/extension-blockquote"
    import Code from "@tiptap/extension-code"
    //Списки
    import ListItem from "@tiptap/extension-list-item"
    import BulletList from "@tiptap/extension-bullet-list"
    import OrderedList from "@tiptap/extension-ordered-list"
    //История
    import History from "@tiptap/extension-history"
    //Таблица
    import Table from "@tiptap/extension-table"
    import TableRow from "@tiptap/extension-table-row"
    import TableCell from "@tiptap/extension-table-cell"
    import TableHeader from "@tiptap/extension-table-header"
  
    import VButton from '@/components/v-Button.vue'
    import VDropdownButton from '@/components/v-DropdownButton.vue'
    import { FontAwesomeIcon } from "/node_modules/@fortawesome/vue-fontawesome"
    import { library } from "/node_modules/@fortawesome/fontawesome-svg-core"
    import { faBold, faItalic, faUnderline, faStrikethrough, faTable, faListUl, faListOl, faUndo, faRepeat } from "/node_modules/@fortawesome/free-solid-svg-icons"

    library.add(faBold, faItalic, faUnderline, faStrikethrough, faTable, faListUl, faListOl, faUndo, faRepeat)

    export default {
        components: {
            EditorContent,
            VButton,
            VDropdownButton,
            FontAwesomeIcon
        },
  
        props: {
            modelValue: {
                type: String,
                default: '',
            },
            placeholder: {
                type: String,
                required: false,
                default: null,
            },
        },

        emits: ['update:modelValue'],

        data() {
            return {
                editor: null,
            }
        },
  
    watch: {
        modelValue(value) {
            const isSame = this.editor.getHTML() === value
            
            if (isSame) {
                return
            }

            this.editor.commands.setContent(value, false)
        },
    },

    mounted() {
        this.editor = new Editor({
            extensions: [
                Document,
                Paragraph,
                Text,
                Placeholder.configure({
                    placeholder: this.placeholder,
                }),
                //
                Bold,
                Italic,
                //
                Underline,
                Strike,
                Blockquote,
                Code,
                //
                TextStyle,
                //
                ListItem,
                BulletList,
                OrderedList,
                //
                History,
                //
                Table.configure({
                    resizable: false,
                }),
                TableRow,
                TableHeader,
                TableCell,
            ],
            content: this.modelValue,
            onUpdate: () => {
                // HTML
                this.$emit('update:modelValue', this.editor.getHTML())
            },
        })
    },
  
    beforeUnmount() {
      this.editor.destroy()
    },

    methods: {
        //Из-за использованию дропбаттона, нужно дополнительно перекидывать фокус на эдитор
        setFocus() {
            this.$nextTick(() => {
                this.editor
                .chain()
                .focus()
                .run()
            })
        },

        toggleUnderline() {
            this.editor
                .chain()
                .toggleUnderline()
                .run()
            this.setFocus()
        },

        toggleStrike() {
            this.editor
                .chain()
                .toggleStrike()
                .run()
            this.setFocus()
        },

        toggleBlockquote() {
            this.editor
                .chain()
                .toggleBlockquote()
                .run()
            this.setFocus()
        },

        toggleCode() {
            this.editor
                .chain()
                .toggleCode()
                .run()
            this.setFocus()
        },

        toggleBulletList() {
            this.editor
                .chain()
                .toggleBulletList()
                .run()
            this.setFocus()
        },

        toggleOrderedList() {
            this.editor
                .chain()
                .toggleOrderedList()
                .run()
            this.setFocus()
        },

        insertTable() {
            this.editor
                .chain()
                .insertTable({ rows: 3, cols: 3 })
                .run()
            this.setFocus()
        },

        deleteTable() {
            this.editor
                .chain()
                .deleteTable()
                .run()
            this.setFocus()
        },

        addColumnBefore() {
            this.editor
                .chain()
                .addColumnBefore()
                .run()
            this.setFocus()
        },

        addColumnAfter() {
            this.editor
                .chain()
                .addColumnAfter()
                .run()
            this.setFocus()
        },

        deleteColumn() {
            this.editor
                .chain()
                .deleteColumn()
                .run()
            this.setFocus()
        },

        addRowBefore() {
            this.editor
                .chain()
                .addRowBefore()
                .run()
            this.setFocus()
        },

        addRowAfter() {
            this.editor
                .chain()
                .addRowAfter()
                .run()
            this.setFocus()
        },

        deleteRow() {
            this.editor
                .chain()
                .deleteRow()
                .run()
            this.setFocus()
        },

        mergeOrSplit() {
            this.editor
                .chain()
                .mergeOrSplit()
                .run()
            this.setFocus()
        },

        ctrlEnter(e) {
            if (e.ctrlKey) {
                this.$emit("ctrlEnter", e)
            }
        },
    },
  }
  </script>

<style>
.editor {
  max-height: 500px;
  overflow-y: auto;
}
.ProseMirror {
  padding: 0.5em;
  border: 1px solid rgba(0, 0, 0, 0.125);
  background-color: #fff;
  border-radius: 4px;
  min-height: 150px;
}
.ProseMirror-focused,
.ProseMirror:focus {
  outline-color: rgba(0, 0, 0, 0.125) !important;
}
.ProseMirror p.is-editor-empty:first-child::before {
  content: attr(data-placeholder);
  float: left;
  color: #adb5bd;
  pointer-events: none;
  height: 0;
}

.menubar {
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 4px;
  margin-bottom: 0.25rem;
}

.menubar-btn {
  border-radius: 0 !important;
}

.menubar .menubar-btn:first-child {
  border-radius: 0.2rem 0 0 0.2rem !important;
}

.menubar .menubar-btn:last-child {
  border-radius: 0 0.2rem 0.2rem 0 !important;
}

.menubar-btn,
.menubar-btn button {
  color: #212529 !important;
}

.menubar-btn.is-active,
.menubar-btn .is-active {
  background-color: rgba(0, 0, 0, 0.1);
}

.shortcut-tooltip {
  background-color: #ced4da;
  border-radius: 0.2rem;
  padding: 3px 6px;
  margin-left: 0.75rem;
}

.tooltip .shortcut-tooltip {
  background-color: rgba(255, 255, 255, 0.3);
  padding: 2px 4px;
  margin-left: 0.5rem;
}
</style>

<style lang="scss">
/* Basic editor styles */
.ProseMirror {
  > * + * {
    margin-top: 0.75em;
  }

  ul,
  ol {
    padding: 0 1rem;
  }

  ul[data-type="taskList"] {
    list-style: none;
    padding: 0;

    p {
      margin: 0;
    }

    li {
      display: flex;

      > label {
        flex: 0 0 auto;
        margin-right: 0.5rem;
        user-select: none;
      }

      > div {
        flex: 1 1 auto;
      }
    }
  }

  table {
    border-collapse: collapse;
    table-layout: fixed;
    width: 100%;
    margin: 0;
    overflow: hidden;

    td,
    th {
      min-width: 1em;
      border: 1px solid rgb(209 213 219 / 0.75);
      padding: 3px 5px;
      vertical-align: top;
      box-sizing: border-box;
      position: relative;

      > * {
        margin-bottom: 0;
      }
    }

    th {
      font-weight: normal;
      text-align: center;
      background-color: rgb(229 231 235 / 0.5);;
    }

    .selectedCell:after {
      z-index: 2;
      position: absolute;
      content: "";
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      background: rgba(200, 200, 255, 0.4);
      pointer-events: none;
    }

    .column-resize-handle {
      position: absolute;
      right: -2px;
      top: 0;
      bottom: -2px;
      width: 4px;
      background-color: #adf;
      pointer-events: none;
    }

    p {
      margin: 0;
    }
  }
}
</style>
