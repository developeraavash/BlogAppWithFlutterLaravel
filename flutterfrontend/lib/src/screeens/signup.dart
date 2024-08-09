import 'package:flutter/material.dart';
import 'package:flutterfrontend/core/theme/app_pallete.dart';
import 'package:flutterfrontend/src/screeens/login.dart';
import 'package:flutterfrontend/src/widgets/auth_feild.dart';
import 'package:flutterfrontend/src/widgets/auth_gradient_button.dart';

class SignUpPage extends StatefulWidget {
  const SignUpPage({super.key});

  @override
  State<SignUpPage> createState() => _SignUpPageState();
}

class _SignUpPageState extends State<SignUpPage> {
  final formKey = GlobalKey<FormState>();

  // !TextEditiong controller
  TextEditingController nameController = TextEditingController();
  TextEditingController emailController = TextEditingController();
  TextEditingController passwordController = TextEditingController();

  @override
  void dispose() {
    nameController.dispose();
    emailController.dispose();
    passwordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    // it will validate every form feild

    return Scaffold(
      body: Padding(
        padding: const EdgeInsets.all(15.0),
        child: Form(
          key: formKey,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            // crossAxisAlignment: Cr,
            children: [
              const Text(
                "Sign Up .",
                style: TextStyle(
                  fontSize: 50,
                  fontWeight: FontWeight.bold,
                ),
              ),
              AuthField(
                hintText: "Name",
                controller: nameController,
              ),
              const SizedBox(
                height: 15,
              ),
              AuthField(
                hintText: "Password",
                controller: passwordController,
              ),
              const SizedBox(
                height: 15,
              ),
              AuthField(
                hintText: "Email",
                controller: passwordController,
              ),
              const SizedBox(
                height: 20,
              ),

              // on signup button click
              AuthGradientBtn(
                onpressed: () {
                  if (formKey.currentState!.validate()) {}
                },
              ),
              const SizedBox(
                height: 20,
              ),
              GestureDetector(
                onTap: () {
                  // Navigate to login page
                  Navigator.pop(context);
                  Navigator.push(context,
                      MaterialPageRoute(builder: (context) => Login()));
                },
                child: RichText(
                  text: TextSpan(
                    text: "Don\'t have and account ? ",
                    style: Theme.of(context).textTheme.titleMedium,
                    children: [
                      TextSpan(
                        text: "Sign In",
                        style: Theme.of(context)
                            .textTheme
                            .titleMedium
                            ?.copyWith(color: AppPallete.gradient2),
                      ),
                    ],
                  ),
                ),
              )
            ],
          ),
        ),
      ),
    );
  }
}
