import { useState } from 'react'
import TomatoComponent from './components/TomatoComponent';
function App() {
  const [count, setCount] = useState(0)

  return (
    <>
      <p>Page Content</p>
      <TomatoComponent/>
    </>
  )
}

export default App
