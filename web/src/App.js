import React, { useCallback, useEffect, useRef, useState } from 'react';
import {
  ChakraProvider,
  Box,
  Text,
  Link,
  VStack,
  Code,
  Grid,
  Button,
  Container,
  Input,
  ColorModeScript, Table, TableCaption, Thead, Tr, Th, Tbody, Td, Icon, useDisclosure,
  createStandaloneToast,
  Modal,
  ModalOverlay,
  ModalContent,
  ModalHeader,
  ModalFooter,
  ModalBody,
  ModalCloseButton,
} from '@chakra-ui/react';
import config from './config';
import axios from 'axios';
import theme from './theme';
import { RepeatIcon } from '@chakra-ui/icons'
import moment from 'moment';

const FileUploader = ({ onFileSelectError, onFileSelectSuccess }) => {
  const fileInput = useRef(null);

  const handleFileInput = (e) => {
    // handle validations

    const file = e.target.files[0];
    console.log(file.size);
    if (file.size > 3951030)
      onFileSelectError({ error: 'File size cannot exceed more than 1MB' });
    else onFileSelectSuccess(file);
  };

  return (
    <div className='file-uploader'>
      <input type='file' onChange={handleFileInput} />
      <button onClick={e => fileInput.current && fileInput.current.click()} className='btn btn-primary'>File</button>
    </div>
  );
};

function App() {
  const [selectedFile, setSelectedFile] = useState(null);
  const [userFiles, setUserFiles] = useState([]);
  const { isOpen, onOpen, onClose } = useDisclosure()
  const [currentFile, setCurrentFile] = useState(null);
  const toast = createStandaloneToast()

  const getUserFiles = () => {
    let formData = new FormData();
    formData.append('file', selectedFile);

    axios({
      url: config.api_url + '/api/files',
      method: 'get',
      headers: {
        'Authorization': 'Bearer ' + config.api_key,
        'Accept': 'application/json',
      },
      mode: 'no-cors',
    }).then((res) => { console.log(res.data); setUserFiles(res.data.files);  })
  }

  const submitFileScan = () => {
    let formData = new FormData();
    formData.append('file', selectedFile);

    axios({
      url: config.api_url + '/api/scan',
      method: 'post',
      headers: {
        'Authorization': 'Bearer ' + config.api_key,
        'Accept': 'application/json',
        'Content-Type': 'multipart/form-data',
        'Access-Control-Allow-Origin': '*'
      },
      mode: 'no-cors',
      data: formData,
    }).then((res) => {
      console.log(res);
      console.log(selectedFile);
      if (204 === res.status) {
        toast({
          title: "Success",
          description: selectedFile.name + ' has just been processed! Please refresh!',
          status: "success",
          duration: 9000,
          isClosable: true,
        })
      }

      toast({
        title: "Error",
        description: 'Something went wrong :(',
        status: "error",
        duration: 9000,
        isClosable: true,
      })
    });
  };

  return (
    <ChakraProvider theme={theme}>
      <Container maxW="container.xl">
        <Box textAlign='center' fontSize='xl'>
          <Grid minH='100vh' p={3}>
            <VStack spacing={8}>
              <Text>{config.api_key && config.api_url ? 'Config OK' : 'Config Not OK'}</Text>

              <FileUploader
                onFileSelectSuccess={(file) => setSelectedFile(file)}
                onFileSelectError={({ error }) => alert(error)}
              />
              {/*<Input type="file" placeholder="Basic usage" onInput={(file) => { setFile(file); }} ref={this.fileInput}/>*/}

              <Button colorScheme='teal' size='md' onClick={() => {
                submitFileScan();
              }}>
                Scan!
              </Button>

              <Button colorScheme='green' size='md' onClick={() => {
                getUserFiles();
              }}>
                <Icon as={RepeatIcon} />
              </Button>
            </VStack>


            <Table variant="simple">
              <TableCaption>Uploaded files</TableCaption>
              <Thead>
                <Tr>
                  <Th>Filename</Th>
                  <Th>Content</Th>
                  <Th>Created At</Th>
                </Tr>
              </Thead>
              <Tbody>
                { userFiles && userFiles.map((item) => {
                  return (
                    <Tr>
                      <Td>{ item.file_name }</Td>
                      <Td><Button onClick={() => {onOpen(); setCurrentFile(item)}}>View</Button></Td>
                      <Td>{ moment(item.updated_at).format('lll') }</Td>
                    </Tr>
                  )
                }) }
              </Tbody>
            </Table>

          </Grid>
        </Box>

        <Modal isOpen={isOpen} onClose={onClose}>
          <ModalOverlay />
          <ModalContent maxW='8xl'>
            <ModalHeader>File Content</ModalHeader>
            <ModalCloseButton />
            <ModalBody>
              <pre>
              { currentFile ? currentFile.content : '' }
              </pre>
            </ModalBody>

            <ModalFooter>
              <Button colorScheme="blue" mr={3} onClick={onClose}>
                Close
              </Button>
            </ModalFooter>
          </ModalContent>
        </Modal>
      </Container>
    </ChakraProvider>
  );
}

export default App;
