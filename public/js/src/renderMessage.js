import { fetchData } from "./api.js"

const messageContainer = document.querySelector('#userMessages')
const messageList = []

const conversationId = location.pathname.split('/')[2]
const apiRoute = `/api/v1/message/user/conversation/${conversationId}`

/**
 *template for a message 
 * @param {object} convMessage 
 * @param {object} user 
 * @returns {string}
 */
const message = (convMessage, user) => {
    return `
<div class="card mt-1">
	<div class="card-header">
		${user.username}
	</div>
	<div class="card-body">
		<p>${convMessage.body}</p>
		<footer class="blockquote-footer">Posté le :
			${convMessage.createdAt}
		</footer>
	</div>
</div>`
}

const addMessageToList = (convMessage) => {
    messageList.push(convMessage.id)
}

export const oneMessage = (convMessage) => {
    addMessageToList(convMessage)
    const messagestring = message(convMessage, convMessage.user)
    const messageDiv = document.createElement('div')
    messageDiv.innerHTML = messagestring
    messageContainer.prepend(messageDiv)
}

const checkMessage = (convMessage) => {
    const messageCheck = messageList.indexOf(convMessage.id)
    if (messageCheck === -1) {
        console.log('generate_message')
        oneMessage(convMessage)
    }
}

export const renderLastMessages = () => {
    console.log('bla')
    const checkEveryMessage = (convMessages) => {
        convMessages.forEach(convMessage => {
            checkMessage(convMessage)
        })
    }
    fetchData(apiRoute, checkEveryMessage)
}

/**
 * render every message in bdd
 * @param {array} convMessages 
 */
const AllMessage = (convMessages) => {
    convMessages.forEach(convMessage => {
        addMessageToList(convMessage)
        messageContainer.innerHTML += message(convMessage, convMessage.user)
    })
}

export const renderAllMessage = () => {
    fetchData(apiRoute, AllMessage)
}