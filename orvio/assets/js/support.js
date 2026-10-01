(function () {
  var root = document.querySelector('[data-support-widget]');
  if (!root || typeof OrvioSupport === 'undefined') return;
  var panel = root.querySelector('[data-support-panel]');
  var launcher = root.querySelector('[data-support-open]');
  var close = root.querySelector('[data-support-close]');
  var form = root.querySelector('[data-support-form]');
  var messages = root.querySelector('[data-support-messages]');
  var error = root.querySelector('[data-support-error]');
  var token = '';
  var since = 0;
  var timer = null;
  try { token = localStorage.getItem('orvio-support-session') || ''; } catch (err) {}

  function setOpen(open) {
    panel.hidden = !open;
    launcher.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (open) {
      poll();
      var input = form.querySelector('textarea');
      if (input) input.focus();
    } else if (timer) {
      window.clearTimeout(timer);
      timer = null;
    }
  }

  function post(action, data) {
    var body = new URLSearchParams();
    body.set('action', action);
    body.set('nonce', OrvioSupport.nonce);
    Object.keys(data || {}).forEach(function (key) { body.set(key, data[key] == null ? '' : data[key]); });
    return fetch(OrvioSupport.ajax, { method: 'POST', credentials: 'same-origin', body: body }).then(function (response) {
      return response.json();
    });
  }

  function formatTime(timestamp) {
    try { return new Date(timestamp * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }); } catch (err) { return ''; }
  }

  function draw(items) {
    (items || []).forEach(function (item) {
      var bubble = document.createElement('div');
      bubble.className = 'orvio-support__message orvio-support__message--' + (item.role || 'system');
      bubble.appendChild(document.createTextNode(item.text || ''));
      if (item.time) {
        var time = document.createElement('small');
        time.className = 'orvio-support__message-time';
        time.textContent = formatTime(item.time);
        bubble.appendChild(time);
      }
      messages.appendChild(bubble);
    });
    messages.scrollTop = messages.scrollHeight;
  }

  function handleResponse(response) {
    if (!response || !response.success) {
      var message = response && response.data && response.data.message ? response.data.message : OrvioSupport.i18n.error;
      error.hidden = false;
      error.textContent = message;
      return false;
    }
    error.hidden = true;
    var data = response.data || {};
    if (data.token) {
      token = data.token;
      try { localStorage.setItem('orvio-support-session', token); } catch (err) {}
    }
    if (typeof data.since === 'number') since = data.since;
    draw(data.messages || []);
    return true;
  }

  function poll() {
    if (!token || panel.hidden) return;
    post('orvio_support_poll', { session: token, since: since }).then(function (response) {
      if (!handleResponse(response) && response && response.data && response.data.message) {
        try { localStorage.removeItem('orvio-support-session'); } catch (err) {}
        token = '';
        since = 0;
      }
    }).catch(function () {}).finally(function () {
      if (!panel.hidden) timer = window.setTimeout(poll, 4000);
    });
  }

  launcher.addEventListener('click', function () { setOpen(panel.hidden); });
  close.addEventListener('click', function () { setOpen(false); });
  form.addEventListener('submit', function (event) {
    event.preventDefault();
    var button = form.querySelector('button[type="submit"]');
    var textarea = form.querySelector('textarea[name="message"]');
    var data = {
      session: token,
      name: form.querySelector('[name="name"]').value,
      email: form.querySelector('[name="email"]').value,
      message: textarea.value
    };
    if (!data.message.trim()) return;
    button.disabled = true;
    post('orvio_support_start', data).then(handleResponse).catch(function () {
      error.hidden = false;
      error.textContent = OrvioSupport.i18n.error;
    }).finally(function () {
      textarea.value = '';
      button.disabled = false;
      poll();
    });
  });

  if (token) {
    post('orvio_support_poll', { session: token, since: 0 }).then(handleResponse).catch(function () {});
  }
})();
