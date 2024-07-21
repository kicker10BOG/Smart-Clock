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
const addFlashMsg = (msg) => {
  msg.id = generateRandomString(16)
  page.props.flash.push(msg)
  axios.put(route('addFlash', {flash: msg}))
}
const removeFlashMsg = (msg) => {
  const i = page.props.flash.indexOf(msg)
  page.props.flash.splice(i, 1)
  axios.delete(route('removeFlash', {flash: msg}))
}

export { addFlashMsg, removeFlashMsg }