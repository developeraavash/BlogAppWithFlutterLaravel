import 'package:flutter/material.dart';
import 'package:flutterfrontend/core/theme/app_pallete.dart';

class AuthGradientBtn extends StatelessWidget {
  final VoidCallback onpressed;
  const AuthGradientBtn({super.key, required this.onpressed});

  @override
  Widget build(BuildContext context) {
    // for gradient wrap with Container
    return Container(
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [
            AppPallete.gradient1,
            AppPallete.gradient2,
          ],
          begin: Alignment.bottomLeft,
          end: Alignment.topRight,
        ),
        borderRadius: BorderRadius.circular(7),
      ),
      child: ElevatedButton(
        onPressed: onpressed,
        style: ElevatedButton.styleFrom(
            fixedSize: const Size(396, 55),
            backgroundColor: AppPallete.transparentColor,
            shadowColor: AppPallete.transparentColor),
        child: const Text(
          "Sign Up",
          style: TextStyle(
            fontSize: 17,
            fontWeight: FontWeight.w600,
          ),
        ),
      ),
    );
  }
}
