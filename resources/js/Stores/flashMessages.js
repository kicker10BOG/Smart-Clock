import { useForm, usePage } from "@inertiajs/vue3"
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
const form = useForm({
  flash: null,
})
const addFlashMsg = (msg) => {
  msg.id = generateRandomString(16)
  form.flash = msg
  page.props.flash.push(msg)
  form.put(route('addFlash'), {
    onError: (e) => console.log(e)
  })
  // axios.put(route('addFlash', {
  //   flash: msg,
  // }))
  //   .then(function (response) {
  //     console.log(response);
  //   })
  //   .catch(function (error) {
  //     console.log(error);
  //   });
}
const removeFlashMsg = (msg) => {
  form.flash = msg
  const i = page.props.flash.indexOf(msg)
  page.props.flash.splice(i, 1)
  form.delete(route('removeFlash'))
  // axios.delete(route('removeFlash', {
  //   flash: msg,
  // }))
  //   .then(function (response) {
  //     console.log(response);
  //   })
  //   .catch(function (error) {
  //     console.log(error);
  //   });
  console.log(page.props.flash)
}

export { addFlashMsg, removeFlashMsg }