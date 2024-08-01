import { usePage } from "@inertiajs/vue3"
import axios from "axios";

function generateRandomString(length) {
  let result = '';
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const charactersLength = characters.length;
  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

const page = usePage()

class Flash {
  constructor(msg) {
    this.id = generateRandomString(16)
    this.title = ''
    this.message = msg
    this.closable = true
    this.delay = 5
    this.type = 'success'
    this.important = false
  }

  setSuccess() {
    this.type = 'success'
    return this
  }
  
  setWarning() {
    this.type = 'warning'
    return this
  }

  setError() {
    this.type = 'error'
    return this
  }

  setInfo() {
    this.type = 'info'
    return this
  }

  setImportant(val = true) {
    this.important = val
    return this
  }

  setDelay(val = 5) {
    this.delay = val
    return this
  }

  setTitle(val = '') {
    this.title = val
    return this
  }

  add() {
    page.props.flash.push(this)
    axios.put(route('addFlash', {flash: this}))
    return this
  }

  remove() {
    for (let i = 0; i < page.props.flash.length; i++) {
      if (page.props.flash[i].id == this.id) {
        page.props.flash.splice(i, 1)
        break
      }
    }
    axios.delete(route('removeFlash', {flash: this}))
  }
}

function flash(msg) {
  if (typeof msg == 'string' || msg instanceof String) {
    let f = new Flash(msg)
    return f
  }
  let f = new Flash(msg.message)
  f.id = msg.id
  f.title = msg.title
  f.closable = msg.closable
  f.delay = msg.delay
  f.type = msg.type
  f.important = msg.important
  return f
}

export { flash }